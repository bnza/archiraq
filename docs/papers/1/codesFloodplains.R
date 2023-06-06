###################################################################################################################
###################################################################################################################
#################          Log file and full codes for analyses contained in the paper              ###############
#################                                  Marchetti et al.                                 ###############
#################                        'Long-term Urban and Population Trends                     ###############
#################                       in the southern Mesopotamian Floodplains'                   ###############
#################                                                                                   ############### 
#################                                                                                   ###############
#################                                                                                   ###############
#################                                                                                   ###############
#################                                  January  2023                                    ###############
#################                                                                                   ###############
#################                                     author:                                       ###############
#################                                                                                   ###############
#################                               Eugenio Bortolini                                   ###############
#################                                                                                   ###############
#################                                                                                   ###############
#################                                      v.1.0                                        ###############
#################                                                                                   ###############
#################                                                                                   ###############
#################                            eugenio.bortolini@unibo.it                             ###############
#################                                                                                   ###############
#################                                                                                   ###############
###################################################################################################################
###################################################################################################################


# The present repository contains data and code to fully replicate the analyses contained in the paper Marchetti et al. Long-term Urban and Population Trends in the southern Mesopotamian Floodplains, submitted to the Journal of Archaeological Research.

#In particular, the following codes allow readers to calculate:

# 1) all the probabilistic, aoristic-based proxies for demographic trends in Southern Mesopotamia presented in the results of the above mentioned paper. This work is largely based on a previous work by Lawrence D, Palmisano A, de Gruchy MW(2021) Collapse and continuity: A multi-proxy reconstruction of settlement organization and population trajectories in the Northern Fertile Crescent during the 4.2kya Rapid Climate Change event. PLoS ONE 16(1): e0244871.
# https://doi.org/10.1371/journal.pone.0244871.


# 2) correlations between selected palaeoclimatic proxies and the probabilistic, aoristic-based proxies for demographic trends in Southern Mesopotamia. This section of the work is based on previous work by Alessio Palmisano and colleagues (2021) Holocene regional population dynamics and climatic trends in the Near East: A ﬁrst comparison using archaeo-demographic proxies, Quaternary Science Reviews 252:106739.
# Full text of the original paper by Palmisano et al. can be accessed at https://doi.org/10.1016/j.quascirev.2020.106739
# All original codes, details on data and relevant metadata can be accessed on Zenodo at http://doi.org/10.5281/zenodo.4322979



# This choice was made to further facilitate replication and merging/exchange of data, methods, and results generated for both Northen and Southern Mesopotamian contexts. Present work and results are therefore particularly indebted to Alessio Palmisano for his previous work and his invaluable suggestions.




################## run on R version 4.2.2 (2022-11-01) ####################


## required libraries

library(doParallel) #v.1.0.16
library(data.table) #v.1.14.0
library(tidyr) #v.1.1.3
library(vegan) #v.2.5-7
library(scico) #v.1.2.0
library(ecodist) #v.2.0.7
library(gtools) #v.3.9.4


## read input file "data_stacked.csv", which can be obtained in the same repository
sites<-read.csv(file="data_stacked.csv", sep=",", header=TRUE) # original data generated in this work
palaeoclimate<-read.csv(file="palaeoclimate.csv", header=TRUE, sep=",") #palaeoclimatic proxies taken by Palmisano et al. 2021


## transform all BCAD dates into BP
StartBP<-(sites$StartDate)-1950
EndBP<-(sites$EndDate)-1950
## add new columns for storing results
sites[,"StartBP"]<-StartBP
sites[,"EndBP"]<-EndBP


## rearrange columns
sites<-sites[c(1:5,9,10,6:8)]

## switch from size classes to extension in ha
a<-(sites[,8])
a<-as.numeric(a)
a<-ifelse(a==1,0.1,
   ifelse(a==2,4.1,
   ifelse(a==3,10.1,
   ifelse(a==4,20.1,
   ifelse(a==5,40.1,
   ifelse(a==6,201,
   0))))))
       
sites[,8]<-a


## Create time blocks (100 yrs) and new columns
blockwidth <- 100
brks <- seq(-4500,1800,by=blockwidth)
mids <- seq(min(brks)+(blockwidth/2),max(brks)-(blockwidth/2),by=blockwidth)
newcolumns <- paste(brks[1:(length(brks)-1)],"start",sep="")



## take zeros off
sites_no0<-sites[which(sites$SizeHa>0),]

                        
## Create new tables for storing results
aoristicweights_no0 <- siteareasums_no0 <- sitecounts_no0 <- sites_no0
sitecounts_no0[newcolumns] <- NA #add new columns
sitecounts_no0 <- sitecounts_no0[,newcolumns] #drop all other columns
aoristicweights_no0[newcolumns] <- NA #add new columns
aoristicweights_no0 <- aoristicweights_no0[,newcolumns]#drop all other columns
siteareasums_no0[newcolumns] <- NA #add new columns
siteareasums_no0 <- siteareasums_no0[,newcolumns] #drop all other columns
aoristicweights_no0 <- siteareasums_no0 <-sitecounts_no0


## Calculate the duration of each site occupation phase
sites_no0$Duration <- abs(sites_no0$EndDate - sites_no0$StartDate)


## Loop through and update timeblocks for each site
for (a in 1:nrow(sites_no0)){
  cat(paste(a,"; ",sep="")) 
  sitestart <- sites_no0$StartDate[a]
  siteend <- sites_no0$EndDate[a]
  siteyears <- seq(sitestart,siteend,by=1)
  print("here")
  siteyearshist <- hist(siteyears, breaks=brks, plot=FALSE) 
  timewts <- siteyearshist$counts/blockwidth
  sitecounts_no0[a,] <- timewts #ordinary counts (but timeblock proportional)
  aoristicweights_no0[a,] <- timewts/sum(timewts) #aoristic weights
  siteareasums_no0[a,] <- timewts*sites_no0$SizeHa[a] #total site area
}



## calculate and store max area per each class
siteareasums_no0_max<-siteareasums_no0
sitestart_max<-sitestart
siteend_max<-siteend
siteyears_max<-siteyears
timewts_max<-timewts


l<-ifelse(sites_no0$SizeHa==0.1, 4, 
   ifelse(sites_no0$SizeHa==4.1,10,
   ifelse(sites_no0$SizeHa==10.1,20,
   ifelse(sites_no0$SizeHa==20.1,40,
   ifelse(sites_no0$SizeHa==40.1,200,
   ifelse(sites_no0$SizeHa==201,201,NA))))))

l<-as.factor(l)
m<-as.numeric(l)

for (a in 1:nrow(sites_no0)){
  cat(paste(a,"; ",sep=""))
  sitestart_max <- sites_no0$StartDate[a]
  siteend_max <- sites_no0$EndDate[a]
  siteyears_max <- seq(sitestart_max,siteend_max,by=1)
  print("here")
  siteyearshist_max <- hist(siteyears_max, breaks=brks, plot=FALSE) 
  timewts_max <- siteyearshist_max$counts/blockwidth
  siteareasums_no0_max[a,] <- timewts_max*m[a] #total site area
}


area_no0_class1_min<-colSums(siteareasums_no0[sites_no0$factorArea=="0.1",])
area_no0_class2_min<-colSums(siteareasums_no0[sites_no0$factorArea=="4.1",])
area_no0_class3_min<-colSums(siteareasums_no0[sites_no0$factorArea=="10.1",])
area_no0_class4_min<-colSums(siteareasums_no0[sites_no0$factorArea=="20.1",])
area_no0_class5_min<-colSums(siteareasums_no0[sites_no0$factorArea=="40.1",])
area_no0_class6_min<-colSums(siteareasums_no0[sites_no0$factorArea=="201",])

area_no0_class1_max<-colSums(siteareasums_no0_max[m=="4",])
area_no0_class2_max<-colSums(siteareasums_no0_max[m=="10",])
area_no0_class3_max<-colSums(siteareasums_no0_max[m=="20",])
area_no0_class4_max<-colSums(siteareasums_no0_max[m=="40",])
area_no0_class5_max<-colSums(siteareasums_no0_max[m=="200",])
area_no0_class6_max<-colSums(siteareasums_no0_max[m=="201",])


## calculate Gini-Simpson diversity, Hill number equivalents, and respective values normalised to unit for each time block
sites_no0$factorArea<-as.factor(sites_no0$SizeHa)
#plot(colSums(aoristicweights_no0[sites_no0$factorArea=="0.1",]) /colSums(aoristicweights_no0), ylim=c(0,1), xlim=c(0,61), type="l")
#lines(colSums(aoristicweights_no0[sites_no0$factorArea=="4.1",]) /colSums(aoristicweights_no0), ylim=c(0,1), col="red")
#lines(colSums(aoristicweights_no0[sites_no0$factorArea=="10.1",]) /colSums(aoristicweights_no0), ylim=c(0,1), col="blue")
#lines(colSums(aoristicweights_no0[sites_no0$factorArea=="20.1",]) /colSums(aoristicweights_no0), ylim=c(0,1), col="forestgreen")
#lines(colSums(aoristicweights_no0[sites_no0$factorArea=="40.1",]) /colSums(aoristicweights_no0), ylim=c(0,1), col="pink")
#lines(colSums(aoristicweights_no0[sites_no0$factorArea=="201",]) /colSums(aoristicweights_no0), ylim=c(0,1), lty=2, lwd=2)

relfreqs<-rbind(
colSums(aoristicweights_no0[sites_no0$factorArea=="0.1",]) /colSums(aoristicweights_no0),
colSums(aoristicweights_no0[sites_no0$factorArea=="4.1",]) /colSums(aoristicweights_no0),
colSums(aoristicweights_no0[sites_no0$factorArea=="10.1",]) /colSums(aoristicweights_no0),
colSums(aoristicweights_no0[sites_no0$factorArea=="20.1",]) /colSums(aoristicweights_no0),
colSums(aoristicweights_no0[sites_no0$factorArea=="40.1",]) /colSums(aoristicweights_no0),
colSums(aoristicweights_no0[sites_no0$factorArea=="201",]) /colSums(aoristicweights_no0))

ginisimpdiv<-apply(relfreqs[,1:61], 2, function(x){diversity(x, index="simpson", MARGIN=1)})
hilln_ginisimp<-(1-ginisimpdiv)^-1
norm.hilln<-(hilln_ginisimp-min(hilln_ginisimp))/(max(hilln_ginisimp)-min(hilln_ginisimp))



## aoristic sums per each size class 
aorweightbyclass<-rbind(
colSums(aoristicweights_no0[sites_no0$factorArea=="0.1",]),
colSums(aoristicweights_no0[sites_no0$factorArea=="4.1",]),
colSums(aoristicweights_no0[sites_no0$factorArea=="10.1",]),
colSums(aoristicweights_no0[sites_no0$factorArea=="20.1",]),
colSums(aoristicweights_no0[sites_no0$factorArea=="40.1",]),
colSums(aoristicweights_no0[sites_no0$factorArea=="201",]))



## Randomised Start Dates and Duration ##
## Randomised start date of site occupation phase (uniform). 
## A site duration randomly generated from a normal distribution with a mean of 200 years and a standard deviations of 50 years is added to the drawn date
## Create time blocks (200 yrs) and new columns to store results of simulation
meanDuration <- 200 # mean of randomised site duration
minDuration <- 10
sdDuration <- 50 # standard deviation
sitesdf<-sites_no0
nsim <- 999 # number of simulations for generating a 95% confidence envelope
simdf <- as.data.frame(matrix(ncol=length(newcolumns), nrow=nsim))
colnames(simdf) <- newcolumns

# First loop to create site durations.
for (b in 1:nsim){
  cat(paste(b,"; ",sep="")) 
  tmpsitecounts <- sitecounts_no0
  tmpsitecounts[] <- NA #blank place to put counts
  sitedur <- rnorm(n=nrow(sitesdf),meanDuration,sdDuration)
  while (any(sitedur<minDuration)){
    sitedur[sitedur<minDuration] <- rnorm(n=length(sitedur[sitedur<minDuration]),meanDuration,sdDuration) # enforce truncation at minDuration
  }
}


# Second loop to count results.
for (b in 1:nsim){
  cat(paste(b,"; ",sep=""))
  for (a in 1:nrow(sitesdf)){
    if (sitedur[a]>=sitesdf$Duration[a]){
      sitestart <- sitesdf$StartDate[a]
      siteend <- sitesdf$EndDate[a]
    } else {
      sitestart <- round(runif(1,min=sitesdf$StartDate[a],max=sitesdf$EndDate[a]-sitedur[a]),0)
      siteend <- round(sitestart + sitedur[a])
    }
    siteyears <- seq(sitestart,siteend,by=1)
    siteyearshist <- hist(siteyears, breaks=brks, plot=FALSE) 
    tmpsitecounts[a,] <- siteyearshist$counts/blockwidth
    #tmpsitecounts[tmpsitecounts[,]>0.005]<-1 # tranformation in order to avoid values proportional to time block for sites count
  }
  simdf[b,] <- colSums(tmpsitecounts, na.rm=TRUE)
}




## Summarise data
sites_no0_BlockSums<- colSums(sitecounts_no0)
sites_no0_BlockSumWeights <- colSums(aoristicweights_no0)
sites_no0_BlockAreaSums <- colSums(siteareasums_no0)
funhi <- function(x){ quantile(x, probs=0.975) } # function defining upper limit of 95% confidence envelope 
funlo <- function(x){ quantile(x, probs=0.025) } # function defining lower limit of 95% confidence envelope
sites_no0_hicount <- apply(simdf,2,funhi) # upper limit of 95% confidence envelope of randomised start date of sites 
sites_no0_lowcount <- apply(simdf,2,funlo) # lower limit of 95% confidence envelope of randomised start date of sites 
sites_no0_medcount <- apply(simdf,2,median) # median of 95% confidence envelope of randomised start date of sites 



##  Normalise all proxies #
# Sites raw count
sites_no0_BlockSums_norm<-((sites_no0_BlockSums-min(sites_no0_BlockSums))/(max(sites_no0_BlockSums) - min(sites_no0_BlockSums)))
# Summed estimated settlement sizes
sites_no0_BlockAreaSums_norm<-((sites_no0_BlockAreaSums-min(sites_no0_BlockAreaSums))/(max(sites_no0_BlockAreaSums) - min(sites_no0_BlockAreaSums)))
# Aoristic weight
sites_no0_BlockSumWeights_norm<-((sites_no0_BlockSumWeights-min(sites_no0_BlockSumWeights))/(max(sites_no0_BlockSumWeights) - min(sites_no0_BlockSumWeights)))


## Normalise randomised start dates of sites
simdf_norm<-simdf 
simdf_norm[,]<-NA
for (a in 1:nrow(simdf_norm)){
  cat(paste(a,"; ",sep=""))
  x<-simdf[a,]
  tmp_norm<-test <- ((x-min(x))/(max(x) - min(x))) 
  simdf_norm[a,] <- tmp_norm    
}                                                         
simdf_norm[is.na(simdf_norm)] <- 0      
funhi <- function(x){ quantile(x, probs=0.975) }         
funlo <- function(x){ quantile(x, probs=0.025) }          
hicount_norm <- apply(simdf_norm,2,funhi)                 
lowcount_norm <- apply(simdf_norm,2,funlo)                
medcount_norm <- apply(simdf_norm,2,median)               
                                
sites_no0_medcount_norm <- ((medcount_norm-min(medcount_norm))/(max(medcount_norm) - min(medcount_norm)))             
                                    
sites_no0_hicount_norm <- ((hicount_norm-min(hicount_norm))/(max(hicount_norm) - min(hicount_norm)))              
                                   
sites_no0_lowcount_norm <- ((lowcount_norm-min(lowcount_norm))/(max(lowcount_norm) - min(lowcount_norm)))



############## CORRELATION BETWEEN DEMOGRAPHY AND CLIMATE ##############
########################################################################

### Kuna Ba cave

#generate a dataframe with values representing the chronological scope
calBC<-data.frame(BC=-4500:0)
calBC$Kuna<- NA #add new column

#extract  Kuna Ba cave's data from the original data frame
Kuna<-palaeoclimate[,c(41,43)]
Kuna[,1]<-Kuna[,1]-1950
Kuna[,1]<-Kuna[,1]*-1
names(Kuna)<-c("BC", "Kuna")#rename columns

#Perform a left outer join: Return all rows from the left table, and any rows with matching keys from the right table
Kuna_merged<-merge(calBC,Kuna,by="BC", all.x=TRUE)
Kuna<-Kuna_merged[,c(1,3)]#drop second column

#Average the climate proxy value (z-score) within a 50 years time-slice
Kuna_mean_100<-colMeans(matrix(Kuna$Kuna.y[1:4500],nrow=100),na.rm = TRUE)*-1

# subset demographic proxies to match climatic proxies between -2038 and -253 BC, and explore their relationship to
# calculate correlation
plot(sites_no0_BlockSumWeights[25:43],Kuna_mean_100[25:43])
plot(sites_no0_BlockAreaSums[25:43],Kuna_mean_100[25:43])

#Correlation test between -2038 and -253 BC
cor.test(sites_no0_BlockSumWeights[25:43],Kuna_mean_100[25:43], method="kendall")
# tau=-0.04, p=0.8
cor.test(sites_no0_BlockAreaSums[25:43],Kuna_mean_100[25:43], method="kendall")
# tau=-0.04, p=0.8



#Lake Zeribar

#generate a dataframe with values representing the chronological scope
calBC<-data.frame(BC=-4500:0)
calBC$Zeribar<- NA #add new column

#extract  Lake Zeribar's data from the original data frame
Zeribar<-palaeoclimate[,c(45,47)]
Zeribar[,1]<-Zeribar[,1]-1950
Zeribar[,1]<-Zeribar[,1]*-1
Zeribar[,2]<-Zeribar[,2]*-1
names(Zeribar)<-c("BC", "Zeribar")#rename columns

#Perform a left outer join: Return all rows from the left table, and any rows with matching keys from the right table
Zeribar_merged<-merge(calBC,Zeribar,by="BC", all.x=TRUE)
Zeribar<-Zeribar_merged[,c(1,3)]#drop second column

#Average the climate proxy value (z-score) within a 500 years time-slice
Zeribar_mean_500<-colMeans(matrix(Zeribar$Zeribar.y[1:4500],nrow=500),na.rm = TRUE)
#-3982 -236

#Sum demographic proxies within a 500 years time-slice, i.e. between -3900 and -500 BC
mat_4Zer<-matrix(sites_no0_BlockSumWeights[6:43], nrow=5)#from 4000 BC to 200 BC
mat_4Zer[4,8]<-NA
mat_4Zer[5,8]<-NA
blockWeight500_4Zer<-colSums(mat_4Zer, na.rm=T)

mat2_4Zer<-matrix(sites_no0_BlockAreaSums[6:43], nrow=5)#from 4000 BC to 200 BC
mat2_4Zer[4,8]<-NA
mat2_4Zer[5,8]<-NA
blockArea500_4Zer<-colSums(mat2_4Zer, na.rm=T)

#Correlation test between estimated settlement counts and area, and Lake Zeribar's climate proxy between 4000BC and 200 BC
plot(Zeribar_mean_500[2:9],blockWeight500_4Zer)
plot(Zeribar_mean_500[2:9],blockArea500_4Zer)
cor.test(Zeribar_mean_500[2:9],blockWeight500_4Zer, method="spearman") #rho=0.76, p=0.04 
cor.test(Zeribar_mean_500[2:9],blockArea500_4Zer, method="spearman")# rho=0.71, p=0.06



#Lake Mirabad

#generate a dataframe with values representing the chronological scope
calBC<-data.frame(BC=-4500:0)
calBC$Mirabad<-NA #add new column #add new column

#extract  Lake Mirabad's data from the original data frame
Mirabad<-palaeoclimate[,c(49,51)]
Mirabad[,1]<-Mirabad[,1]-1950
Mirabad[,1]<-Mirabad[,1]*-1
Mirabad[,2]<-Mirabad[,2]*-1
names(Mirabad)<-c("BC", "Mirabad")#rename columns

#Perform a left outer join: Return all rows from the left table, and any rows with matching keys from the right table
Mirabad_merged<-merge(calBC,Mirabad,by="BC", all.x=TRUE)
Mirabad<-Mirabad_merged[,c(1,3)]#drop second column

#Average the climate proxy value (z-score) within a 400 years time-slice
Mirabad_mean_500<-colMeans(matrix(Mirabad$Mirabad.y[1:4500],nrow=500),na.rm = TRUE)
# from -4082 to -50
# settlements from 4100 to 100 BC

#Sum demographic proxies within a 500 years time-slice, i.e. between -4100 and -100 BC
mat_4Mir<-matrix(sites_no0_BlockSumWeights[5:45], nrow=5)#from 4100 BC to 100 BC
mat_4Mir[2,9]<-NA
mat_4Mir[3,9]<-NA
mat_4Mir[4,9]<-NA
mat_4Mir[5,9]<-NA
blockWeight500_4Mir<-colSums(mat_4Mir, na.rm=T)

mat2_4Mir<-matrix(sites_no0_BlockAreaSums[5:45], nrow=5)#from 4100 BC to 100 BC
mat2_4Mir[2,9]<-NA
mat2_4Mir[3,9]<-NA
mat2_4Mir[4,9]<-NA
mat2_4Mir[5,9]<-NA
blockArea500_4Mir<-colSums(mat2_4Mir, na.rm=T)

#Correlation test between estimates for period 4100 BC-100BC with lake Mirabad
plot(Mirabad_mean_500,blockWeight500_4Mir)
plot(Mirabad_mean_500,blockArea500_4Mir)
cor.test(Mirabad_mean_500,blockWeight500_4Mir, method="spearman") #rho=0.13, p=0.74 
cor.test(Mirabad_mean_500,blockArea500_4Mir, method="spearman")# rho=-0.25, p=0.52


######### end of analyses #######
#################################









########### plot figures ###########
####################################


####### Plot overlapped normalised trends - Fig3 in the paper #######
#####################################################################

# create additional ad hoc palettes for the following figures
pal<-scico(19, alpha = NULL, begin = 0, end = 1, direction = 1, palette = "bamako")
pal2<-scico(19, alpha = NULL, begin = 0, end = 1, direction = 1, palette = "vik")
palNorm<-scico(20, alpha = 0.8, begin = 0, end = 1, direction = 1, palette = "oleron")

pdf(file="Fig3.pdf", width=8, height=7) 
layout(matrix(c(1,2,3), 3, 1, byrow=TRUE), widths=8.5, heights=c(2.3,2,2.5))

#first block
par(mar=c(0, 2, 0.3, 0.5)) #c(bottom, left, top, right)
xticks <- seq(-4500,1300,200)
plot(sites_no0_BlockSums_norm[1:58]~mids[1:58], lty="solid", col="white", cex.axis=0.5, xaxt="n", yaxt="n",type="l", xlab="", ylab="", xlim=c(-4500,1300), ylim=c(0,1.1))
rect(-2350,-1,-1950,2,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-1,-2200,2,col="gray77", border=NA)
rect(-3300,-1,-3100,2,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)
rect(-1250,-1,-950,2, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)

lines(mids[1:58],sites_no0_BlockSums_norm[1:58], lty="solid", col=palNorm[1], lwd=3)
polygon(x=c(mids[1:58],rev(mids[1:58])), y=c(sites_no0_hicount_norm[1:58],rev(sites_no0_lowcount_norm[1:58])), col=palNorm[8], border=palNorm[7])
lines(mids[1:58],sites_no0_BlockSumWeights_norm[1:58], lty="solid", col=pal[17], lwd=3)

abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,1, 0.2), lwd=0.8, lty="dotted", col="grey80")


####
rect(-4500,1.13,-4110,1.02,col=pal[1], border=NA)
rect(-4100,1.13,-3510,1.02,col=pal[2], border=NA)
rect(-3500,1.13,-3110,1.02,col=pal[3], border=NA)
rect(-3100,1.13,-2910,1.02,col=pal[4], border=NA)
rect(-2900,1.13,-2710,1.02,col=pal[5], border=NA)
rect(-2700,1.13,-2360,1.02,col=pal[6], border=NA)
rect(-2350,1.13,-2110,1.02,col=pal[7], border=NA)
rect(-2100,1.13,-2000,1.02,col=pal[8], border=NA)
rect(-1999,1.13,-1810,1.02,col=pal[9], border=NA)
rect(-1800,1.13,-1610,1.02,col=pal[10], border=NA)
rect(-1600,1.13,-1410,1.02,col=pal[11], border=NA)
rect(-1400,1.13,-1110,1.02,col=pal[12], border=NA)
rect(-1100,1.13,-560,1.02,col=pal[13], border=NA)
rect(-550,1.13,-340,1.02,col=pal[14], border=NA)
rect(-330,1.13,-130,1.02,col=pal[15], border=NA)
rect(-120,1.13,230,1.02,col=pal[16], border=NA)
rect(220,1.13,660,1.02,col=pal[17], border=NA)
rect(650,1.13,1300,1.02,col=pal[18], border=NA)
#rect(1500,1.13,1700,1.02,col=pal[19], border=NA)

text(x=-4300, y=1.07, labels="Ubaid", font = 2, cex = 0.7, col=pal[19])
text(x=-3800, y=1.07, labels="E-M Uruk", font = 2, cex = 0.7, col=pal[18])
text(x=-3300, y=1.07, labels="L Uruk", font = 2, cex = 0.7, col=pal[17])
text(x=-3010, y=1.07, labels="JN", font = 2, cex = 0.7, col=pal[16])
text(x=-2800, y=1.07, labels="EDI-II", font = 2, cex = 0.5, col=pal[16])
text(x=-2530, y=1.07, labels="EDIII", font = 2, cex = 0.7, col=pal[16])
text(x=-2250, y=1.07, labels="Akk", font = 2, cex = 0.7, col=pal[16])
text(x=-2050, y=1.07, labels="UrIII", font = 2, cex = 0.4, col=pal[16])
text(x=-1900, y=1.07, labels="IL", font = 2, cex = 0.7, col=pal[16])
text(x=-1700, y=1.07, labels="OB", font = 2, cex = 0.7, col=pal[16])
text(x=-1500, y=1.07, labels="Kas", font = 2, cex = 0.7, col=pal[16])
text(x=-1250, y=1.07, labels="MB", font = 2, cex = 0.7, col=pal[16])
text(x=-850, y=1.07, labels="NB", font = 2, cex = 0.7, col=pal[16])
text(x=-450, y=1.07, labels="Ach", font = 2, cex = 0.7, col=pal[6])
text(x=-230, y=1.07, labels="Hel", font = 2, cex = 0.7, col=pal[5])
text(x=50, y=1.07, labels="Parthian", font = 2, cex = 0.7, col=pal[4])
text(x=430, y=1.07, labels="Sasanian", font = 2, cex = 0.7, col=pal[3])
text(x=1000, y=1.07, labels="Islamic", font = 2, cex = 0.7, col=pal[2])
#text(x=1580, y=1.07, labels="Ott", font = 2, cex = 0.5, col=pal[1])

####

legend(x=-4400, y=0.92, legend=c("Raw site count","Site count (randomised start)","Aoristic sum"),lty=c("solid","solid","solid"), lwd=c(3,7,3), col=c(palNorm[1], palNorm[8], pal[17]), cex=0.9, bg="transparent",bty="n")
text(x=-4600, y=1.07, labels="a", font = 2, cex = 1.2)
text(x=-3650, y=0.65, labels="n.sites = 3420, site-phases= 9695", cex=0.9)
axis(side=2, at=seq(0,1,0.2), tick=T, labels=seq(0,1,0.2), las=1, cex.axis=0.6)

# second block
box()
par(mar=c(0, 2, 0.3, 0.5)) #c(bottom, left, top, right)
plot(as.numeric(sites_no0_BlockAreaSums_norm)[1:58]~mids[1:58], lty="solid", col="white", cex.axis=0.5, xaxt="n", 
   yaxt="n", type="l", xlab="", ylab="", xlim=c(-4500,1300))
rect(-2350,-1,-1950,2,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-1,-2200,2,col="gray77", border=NA)
rect(-3300,-1,-3100,2,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)
rect(-1250,-1,-950,2, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
lines(mids[1:58],sites_no0_BlockAreaSums_norm[1:58], lty="solid", col=palNorm[5], lwd=3)
lines(mids[1:58], norm.hilln[1:58], col=palNorm[11], lty=1, lwd=3)

abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,1, 0.2), lwd=0.8, lty="dotted", col="grey80")
legend(x=-4400, y=0.92, legend=c("Minimum area (Ha)", "Normalised Hill's number"),
       lty=c("solid","solid"), lwd=c(3,3), col=c(palNorm[5], palNorm[11]), 
                                                  cex=0.9, bg="transparent", bty="n")
#text(x=-4600, y=0.97, labels="b", font = 2, cex = 1.2)
#axis(side=1, at=xticks, labels=xticks, las=2, cex.axis=0.6)
text(x=-4600, y=0.97, labels="b", font = 2, cex = 1.2)
axis(side=2, at=seq(0,1,0.2), labels=seq(0,1,0.2), las=1, cex.axis=0.6)

#mtext("BCE/CE",1, 2.6, at=-1700, adj=0, font=2, cex=0.6, las=1)

# third block
box()
par(mar=c(4, 2, 0.3, 0.5), xpd=F) #c(bottom, left, top, right)
plot(as.numeric(sites_no0_BlockAreaSums_norm)[1:58]~mids[1:58], lty="solid", col="white", cex.axis=0.5, xaxt="n", 
     yaxt="n", type="l", xlab="", ylab="", xlim=c(-4500,1300), cex.lab=0.9)
#rect(-4800,-200,1800,6500,col="gray90", border=NA)
abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey80")
abline(h=seq(0,1, 0.2), lwd=0.8, lty="dotted", col="grey80")
rect(-2350,-1,-1950,2,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-1,-2200,2,col="gray77", border=NA)

rect(-3300,-1,-3100,2,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)

rect(-1250,-1,-950,2, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)

box()
axis(side=1, at=xticks, labels=xticks, las=2, cex.axis=0.8)
axis(side=2, at=seq(0,1,0.2), labels=seq(0,1,0.2), las=1, cex.axis=0.6)

 

lines(mids[1:58],relfreqs[1,1:58], lty="solid", lwd=3, col=pal2[2])
lines(mids[1:58],relfreqs[2,1:58], lty="solid", lwd=3, col=pal2[5])
lines(mids[1:58],relfreqs[3,1:58], lty="solid", lwd=3, col=pal2[7])
lines(mids[1:58],relfreqs[4,1:58], lty="solid", lwd=3, col=pal2[9])
lines(mids[1:58],relfreqs[5,1:58], lty="solid", lwd=3, col=pal2[13])
lines(mids[1:58],relfreqs[6,1:58], lty="solid", lwd=3, col=c(pal2[17], alpha=0.6))

text(x=-4600, y=0.97, labels="c", font = 2, cex = 1.2)
legend(x=-4400, y=0.78, legend=c("Class1", "Class2", "Class3", "Class4", "Class5", "Class6"),
       lty=c("solid","solid","solid","solid","solid","solid"), 
       lwd=c(4,4,4,4,4,4), 
       col=pal2[c(2,5,7,9,13,17)], 
       cex=0.9, bg="transparent", bty="n")

mtext("BCE/CE",1, 2.9, at=-1700, adj=0, font=2, cex=0.6, las=1)


#axis(side=1, at=xticks-50, labels=xticks-2000, las=2, cex.axis=0.8,pos=-0.31)# add BC/AD axis
#mtext("BC",1, 4.9, at=5850, adj=0, font=2, cex=0.8, las=2) 

dev.off()













####### Plot overlapped normalised aoristic weights for each size class - Fig4 in the paper #######
###################################################################################################

pdf(file="Fig4.pdf", width=11, height=4.6) 

xticks <- seq(-4500,1300,200)
#par(mar=c(0.5, 2, 0.5, 0.5)) #c(bottom, left, top, right)

plot(mids[1:58],aorweightbyclass[1,1:58], lty="solid", col="white", cex.axis=0.5, xaxt="n", yaxt="n",type="l", xlab="", ylab="", xlim=c(-4500,1300), ylim=c(0,1.1))
#par(mar=c(0, 1, 0.3, 0.5)) #c(bottom, left, top, right)

#rect(-4800,-200,1800,6500,col="gray90", border=NA)
abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey80")
abline(h=seq(0,1, 0.2), lwd=0.8, lty="dotted", col="grey80")
rect(-2350,-1,-1950,2,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-1,-2200,2,col="gray77", border=NA)

rect(-3300,-1,-3100,2,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)

rect(-1250,-1,-950,2, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)


axis(side=1, at=xticks, labels=xticks, las=2, cex.axis=0.8)
axis(side=2, at=seq(0,1,0.2), labels=seq(0,1,0.2), las=1, cex.axis=0.6)

 

lines(mids[1:58],(aorweightbyclass[1,1:58] - min(aorweightbyclass[1,1:58])) / (max(aorweightbyclass[1,1:58]) - min(aorweightbyclass[1,1:58])), lty="solid", lwd=3, col=pal2[2])

lines(mids[1:58],(aorweightbyclass[2,1:58] - min(aorweightbyclass[2,1:58])) / (max(aorweightbyclass[2,1:58]) - min(aorweightbyclass[2,1:58])), lty="solid", lwd=3, col=pal2[5]))

lines(mids[1:58],(aorweightbyclass[3,1:58] - min(aorweightbyclass[3,1:58])) / (max(aorweightbyclass[3,1:58]) - min(aorweightbyclass[3,1:58])), lty="solid", lwd=3, col=pal2[7])

lines(mids[1:58],(aorweightbyclass[4,1:58] - min(aorweightbyclass[4,1:58])) / (max(aorweightbyclass[4,1:58]) - min(aorweightbyclass[4,1:58])), lty="solid", lwd=3, col=pal2[9])

lines(mids[1:58],(aorweightbyclass[5,1:58] - min(aorweightbyclass[5,1:58])) / (max(aorweightbyclass[5,1:58]) -min(aorweightbyclass[5,1:58])), lty="solid", lwd=3, col=pal2[13])

lines(mids[1:58],(aorweightbyclass[6,1:58] - min(aorweightbyclass[6,1:58])) / (max(aorweightbyclass[6,1:58]) - min(aorweightbyclass[6,1:58])), lty="solid", lwd=3, col=c(pal2[17]))


####
rect(-4500,1.13,-4110,1.02,col=pal[1], border=NA)
rect(-4100,1.13,-3510,1.02,col=pal[2], border=NA)
rect(-3500,1.13,-3110,1.02,col=pal[3], border=NA)
rect(-3100,1.13,-2910,1.02,col=pal[4], border=NA)
rect(-2900,1.13,-2710,1.02,col=pal[5], border=NA)
rect(-2700,1.13,-2360,1.02,col=pal[6], border=NA)
rect(-2350,1.13,-2110,1.02,col=pal[7], border=NA)
rect(-2100,1.13,-2000,1.02,col=pal[8], border=NA)
rect(-1999,1.13,-1810,1.02,col=pal[9], border=NA)
rect(-1800,1.13,-1610,1.02,col=pal[10], border=NA)
rect(-1600,1.13,-1410,1.02,col=pal[11], border=NA)
rect(-1400,1.13,-1110,1.02,col=pal[12], border=NA)
rect(-1100,1.13,-560,1.02,col=pal[13], border=NA)
rect(-550,1.13,-340,1.02,col=pal[14], border=NA)
rect(-330,1.13,-130,1.02,col=pal[15], border=NA)
rect(-120,1.13,230,1.02,col=pal[16], border=NA)
rect(220,1.13,660,1.02,col=pal[17], border=NA)
rect(650,1.13,1300,1.02,col=pal[18], border=NA)
#rect(1500,1.13,1700,1.02,col=pal[19], border=NA)

text(x=-4300, y=1.07, labels="Ubaid", font = 2, cex = 0.7, col=pal[19])
text(x=-3800, y=1.07, labels="E-M Uruk", font = 2, cex = 0.7, col=pal[18])
text(x=-3300, y=1.07, labels="L Uruk", font = 2, cex = 0.7, col=pal[17])
text(x=-3010, y=1.07, labels="JN", font = 2, cex = 0.7, col=pal[16])
text(x=-2800, y=1.07, labels="EDI-II", font = 2, cex = 0.5, col=pal[16])
text(x=-2530, y=1.07, labels="EDIII", font = 2, cex = 0.7, col=pal[16])
text(x=-2250, y=1.07, labels="Akk", font = 2, cex = 0.7, col=pal[16])
text(x=-2050, y=1.07, labels="UrIII", font = 2, cex = 0.4, col=pal[16])
text(x=-1900, y=1.07, labels="IL", font = 2, cex = 0.7, col=pal[16])
text(x=-1700, y=1.07, labels="OB", font = 2, cex = 0.7, col=pal[16])
text(x=-1500, y=1.07, labels="Kas", font = 2, cex = 0.7, col=pal[16])
text(x=-1250, y=1.07, labels="MB", font = 2, cex = 0.7, col=pal[16])
text(x=-850, y=1.07, labels="NB", font = 2, cex = 0.7, col=pal[16])
text(x=-450, y=1.07, labels="Ach", font = 2, cex = 0.7, col=pal[6])
text(x=-230, y=1.07, labels="Hel", font = 2, cex = 0.7, col=pal[5])
text(x=50, y=1.07, labels="Parthian", font = 2, cex = 0.7, col=pal[4])
text(x=430, y=1.07, labels="Sasanian", font = 2, cex = 0.7, col=pal[3])
text(x=1000, y=1.07, labels="Islamic", font = 2, cex = 0.7, col=pal[2])
#text(x=1580, y=1.07, labels="Ott", font = 2, cex = 0.5, col=pal[1])

####





text(x=-4600, y=0.97, labels="", font = 2, cex = 1.2)
legend(x=-4400, y=0.95, legend=c("Class1", "Class2", "Class3", "Class4", "Class5", "Class6"),
       lty=c("solid","solid","solid","solid","solid","solid"), 
       lwd=c(4,4,4,4,4,4), 
       col=pal2[c(2,5,7,9,13,17)], 
       cex=0.9, bg="transparent", bty="n")


mtext("BCE/CE",1, 2.9, at=-1700, adj=0, font=2, cex=0.6, las=1)


#axis(side=1, at=xticks-50, labels=xticks-2000, las=2, cex.axis=0.8,pos=-0.31)# add BC/AD axis
#mtext("BC",1, 4.9, at=5850, adj=0, font=2, cex=0.8, las=2) 

dev.off()






########## Fig.S1 - Supplementary Materials final version #############
#######################################################################

## plot individual demographic estimates per each dimensional class

pdf(file="FigS1.pdf", width=7, height=9.5) 
layout(matrix(c(1,2,3,4,5,6), 6, 1, byrow=TRUE), widths=8.5, heights=c(0.08,0.08,0.08,0.08,0.08,0.11))


#first block
par(mar=c(0, 4, 0.3, 0.5)) #c(bottom, left, top, right)
xticks <- seq(-4500,1300,200)
plot(mids[1:58],aorweightbyclass[1,1:58], lty="solid", col="white", cex.axis=0.5, xaxt="n", yaxt="n",type="l", xlab="", ylab="", xlim=c(-4500,1300), ylim=c(0,450))
rect(-2350,-1,-1950,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-1,-2200,400,col="gray77", border=NA)
rect(-3300,-1,-3100,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)
rect(-1250,-1,-950,400, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)

lines(mids[1:58],aorweightbyclass[1,1:58], lty="solid", lwd=3, col=pal2[2])



#lines(mids[1:58],relfreqs[6,1:58], lty="solid", lwd=3, col=c(pal2[17], alpha=0.6))


abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,450, 100), lwd=0.8, lty="dotted", col="grey80")
axis(side=2, at=seq(0,450,100), labels=c("0","100","200", "300", "400"), las=1, cex.axis=0.8)

text(x=-4500, y=250, labels="Class 1", font = 2, cex = 0.7)

rect(-4500,440,-4110,340,col=pal[1], border=NA)
rect(-4100,440,-3510,340,col=pal[2], border=NA)
rect(-3500,440,-3110,340,col=pal[3], border=NA)
rect(-3100,440,-2910,340,col=pal[4], border=NA)
rect(-2900,440,-2710,340,col=pal[5], border=NA)
rect(-2700,440,-2360,340,col=pal[6], border=NA)
rect(-2350,440,-2110,340,col=pal[7], border=NA)
rect(-2100,440,-2000,340,col=pal[8], border=NA)
rect(-1999,440,-1810,340,col=pal[9], border=NA)
rect(-1800,440,-1610,340,col=pal[10], border=NA)
rect(-1600,440,-1410,340,col=pal[11], border=NA)
rect(-1400,440,-1110,340,col=pal[12], border=NA)
rect(-1100,440,-560,340,col=pal[13], border=NA)
rect(-550,440,-340,340,col=pal[14], border=NA)
rect(-330,440,-130,340,col=pal[15], border=NA)
rect(-120,440,230,340,col=pal[16], border=NA)
rect(220,440,660,340,col=pal[17], border=NA)
rect(650,440,1300,340,col=pal[18], border=NA)
#rect(1500,1.13,1700,1.02,col=pal[19], border=NA)

text(x=-4300, y=390, labels="Ubaid", font = 2, cex = 0.5, col=pal[19])
text(x=-3800, y=390, labels="E-M Uruk", font = 2, cex = 0.5, col=pal[18])
text(x=-3300, y=390, labels="L Uruk", font = 2, cex = 0.5, col=pal[17])
text(x=-3010, y=390, labels="JN", font = 2, cex = 0.5, col=pal[16])
text(x=-2800, y=390, labels="EDI-II", font = 2, cex = 0.35, col=pal[16])
text(x=-2530, y=390, labels="EDIII", font = 2, cex = 0.5, col=pal[16])
text(x=-2250, y=390, labels="Akk", font = 2, cex = 0.5, col=pal[16])
text(x=-2040, y=390, labels="UrIII", font = 2, cex = 0.35, col=pal[16])
text(x=-1900, y=390, labels="IL", font = 2, cex = 0.5, col=pal[15])
text(x=-1700, y=390, labels="OB", font = 2, cex = 0.5, col=pal[15])
text(x=-1500, y=390, labels="Kas", font = 2, cex = 0.5, col=pal[7])
text(x=-1250, y=390, labels="MB", font = 2, cex = 0.5, col=pal[7])
text(x=-850, y=390, labels="NB", font = 2, cex = 0.5, col=pal[7])
text(x=-450, y=390, labels="Ach", font = 2, cex = 0.5, col=pal[6])
text(x=-230, y=390, labels="Hel", font = 2, cex = 0.5, col=pal[5])
text(x=50, y=390, labels="Parthian", font = 2, cex = 0.5, col=pal[4])
text(x=430, y=390, labels="Sasanian", font = 2, cex = 0.5, col=pal[3])
text(x=1000, y=390, labels="Islamic", font = 2, cex = 0.5, col=pal[2])
#text(x=1580, y=1.07, labels="Ott", font = 2, cex = 0.5, col=pal[1])


#second block
par(mar=c(0, 4, 0.3, 0.5)) #c(bottom, left, top, right)
xticks <- seq(-4500,1300,200)
plot(mids[1:58],aorweightbyclass[1,1:58], lty="solid", col="white", cex.axis=0.5, xaxt="n", yaxt="n",type="l", xlab="", ylab="", xlim=c(-4500,1300), ylim=c(0,90))
rect(-2350,-1,-1950,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-1,-2200,400,col="gray77", border=NA)
rect(-3300,-1,-3100,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)
rect(-1250,-1,-950,400, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)


lines(mids[1:58],aorweightbyclass[2,1:58], lty="solid", lwd=3, col=pal2[5])



abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,90, 20), lwd=0.8, lty="dotted", col="grey80")
axis(side=2, at=seq(0,90,20), labels=c("0","20","40", "60", "80"), las=1, cex.axis=0.8)

text(x=-4500, y=80, labels="Class 2", font = 2, cex = 0.7)


#third block

par(mar=c(0, 4, 0.3, 0.5)) #c(bottom, left, top, right)
xticks <- seq(-4500,1300,200)
plot(mids[1:58],aorweightbyclass[1,1:58], lty="solid", col="white", cex.axis=0.5, xaxt="n", yaxt="n",type="l", xlab="", ylab="", xlim=c(-4500,1300), ylim=c(0,50))
rect(-2350,-1,-1950,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-1,-2200,400,col="gray77", border=NA)
rect(-3300,-1,-3100,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)
rect(-1250,-1,-950,400, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)


lines(mids[1:58],aorweightbyclass[3,1:58], lty="solid", lwd=3, col=pal2[7])

abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,50, 10), lwd=0.8, lty="dotted", col="grey80")
axis(side=2, at=seq(0,50,10), labels=c("0","10", "20","30","40","50"), las=1, cex.axis=0.8)

text(x=-4500, y=45, labels="Class 3", font = 2, cex = 0.7)


#fourth block

par(mar=c(0, 4, 0.3, 0.5)) #c(bottom, left, top, right)
xticks <- seq(-4500,1300,200)
plot(mids[1:58],aorweightbyclass[1,1:58], lty="solid", col="white", cex.axis=0.5, xaxt="n", yaxt="n",type="l", xlab="", ylab="", xlim=c(-4500,1300), ylim=c(0,18))
rect(-2350,-1,-1950,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-1,-2200,400,col="gray77", border=NA)
rect(-3300,-1,-3100,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)
rect(-1250,-1,-950,400, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)


lines(mids[1:58],aorweightbyclass[4,1:58], lty="solid", lwd=3, col=pal2[9])

abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,18, 5), lwd=0.8, lty="dotted", col="grey80")
axis(side=2, at=seq(0,18,5), labels=c("0","5", "10","15"), las=1, cex.axis=0.8)

text(x=-4500, y=17, labels="Class 4", font = 2, cex = 0.7)


#fifth block
par(mar=c(0, 4, 0.3, 0.5)) #c(bottom, left, top, right)
xticks <- seq(-4500,1300,200)
plot(mids[1:58],aorweightbyclass[1,1:58], lty="solid", col="white", cex.axis=0.5, xaxt="n", yaxt="n",type="l", xlab="", ylab="", xlim=c(-4500,1300), ylim=c(0,15))
rect(-2350,-1,-1950,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-1,-2200,400,col="gray77", border=NA)
rect(-3300,-1,-3100,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)
rect(-1250,-1,-950,400, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)


lines(mids[1:58],aorweightbyclass[5,1:58], lty="solid", lwd=3, col=pal2[15])

abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,15, 5), lwd=0.8, lty="dotted", col="grey80")
axis(side=2, at=seq(0,15,5), labels=c("0","5", "10","15"), las=1, cex.axis=0.8)

text(x=-4500, y=13, labels="Class 5", font = 2, cex = 0.7)


#sixth block
par(mar=c(5, 4, 0.3, 0.5)) #c(bottom, left, top, right)
xticks <- seq(-4500,1300,200)
plot(mids[1:58],aorweightbyclass[1,1:58], lty="solid", col="white", cex.axis=0.5, xaxt="n", yaxt="n",type="l", xlab="", ylab="", xlim=c(-4500,1300), ylim=c(0,4))
rect(-2350,-1,-1950,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-1,-2200,400,col="gray77", border=NA)
rect(-3300,-1,-3100,400,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)
rect(-1250,-1,-950,400, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)


lines(mids[1:58],aorweightbyclass[6,1:58], lty="solid", lwd=3, col=pal2[17])

abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,4, 1), lwd=0.8, lty="dotted", col="grey80")
axis(side=2, at=seq(0,4,1), labels=c("0","1", "2","3","4"), las=1, cex.axis=0.8)


text(x=-4500, y=4, labels="Class 6", font = 2, cex = 0.7)

axis(side=1, at=xticks, labels=xticks, las=2, cex.axis=0.8)
mtext("BCE/CE",1, 2.9, at=-1700, adj=0, font=2, cex=0.6, las=1)

dev.off()










###### FIG. S2 PALEOCLIMATIC PROXIES #########
##############################################


# create additional ad hoc palettes for the following figures
pal<-scico(19, alpha = NULL, begin = 0, end = 1, direction = 1, palette = "bamako")
pal2<-scico(19, alpha = NULL, begin = 0, end = 1, direction = 1, palette = "vik")
palNorm<-scico(20, alpha = 0.8, begin = 0, end = 1, direction = 1, palette = "oleron")

pdf(file="FigS2.pdf", width=12, height=9) 
layout(matrix(c(1,2), 2, 1, byrow=TRUE), widths=8.5, heights=c(1.9,2.5))

#first block
par(mar=c(0, 6, 0.3, 0.5)) #c(bottom, left, top, right)
xticks <- seq(-4100,-100,200)


#panel 1 , yaxt="n"
plot(Kuna$Kuna.y~Kuna$BC, lty="solid", col="black", cex.axis=0.9, xaxt="n",type="l", xlab="",  xlim=c(-4100,-100), ylim=c(2.5,-2.5), ylab=expression(paste(sigma^18,"O","(z-score)")), cex.lab=1.3)
rect(-2350,-2.5,-1950,2.5,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-2.5,-2200,2.5,col="gray77", border=NA)
rect(-3300,-2.5,-3100,2.5,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)
rect(-1250,-2.5,-950,2.5, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)

lines(Kuna_merged$Kuna.y[which(!is.na(Kuna_merged$Kuna.y))]~Kuna_merged$BC[which(!is.na(Kuna_merged$Kuna.y))], type="l", col=pal2[3], lwd=3)
lines(-Mirabad_merged$Mirabad.y[which(!is.na(Mirabad_merged$Mirabad.y))]~Mirabad_merged$BC[which(!is.na(Mirabad_merged$Mirabad.y))], type="l", col=pal2[7], lwd=3)
lines(-Zeribar_merged$Zeribar.y[which(!is.na(Zeribar_merged$Zeribar.y))]~Zeribar_merged$BC[which(!is.na(Zeribar_merged$Zeribar.y))], type="l", col=pal2[16], lwd=3)

abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(2.5,-2.5, -0.25), lwd=0.8, lty="dotted", col="grey80")

legend(x=-4100, y=-2.3, legend=c("Kuna Ba Cave","Lake Mirabad","Lake Zeribar"),lty=c("solid","solid","solid"), lwd=c(4,4,4), col=c(pal2[3], pal2[7], pal2[16]), cex=1.1, bg="transparent", bty="n")
text(x=-4200, y=-2.5, labels="a", font = 2, cex = 1.2)

# panel 2
box()
par(mar=c(6, 6, 0.3, 0.5))

plot(Kuna$Kuna.y~Kuna$BC, lty="solid", col="black", cex.axis=0.9, xaxt="n", type="l", xlab="",  xlim=c(-4100,-100), ylim=c(0,1), ylab="Normalised demographic proxies", cex.lab=1.3)

rect(-2350,-2.5,-1950,2.5,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
rect(-2300,-2.5,-2200,2.5,col="gray77", border=NA)
rect(-3300,-2.5,-3100,2.5,col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)
#rect(-3250,-1,-3150,2,col="gray77", border=NA)
rect(-1250,-2.5,-950,2.5, col=rgb(192,192,192,alpha=120, maxColorValue=255), border=NA)

lines(mids[5:44],sites_no0_BlockSumWeights_norm[5:44], lty="solid", col=pal[17], lwd=3.5)
lines(mids[5:44],sites_no0_BlockAreaSums_norm[5:44], lty="solid", col=palNorm[5], lwd=3.5)

abline(v=seq(-4500,1300,200), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,1, 0.1), lwd=0.8, lty="dotted", col="grey80")

axis(side=1, at=xticks, labels=xticks, las=2, cex.axis=0.9)
mtext("BCE/CE",1, 4.4, at=-2300, adj=0, font=2, cex=1.2, las=1)

legend(x=-4100, y=0.9, legend=c("Aoristic sum","Minimum area (Ha)"),lty=c("solid","solid"), lwd=c(4,4), col=c(pal[17], palNorm[5]), cex=1.1, bg="transparent", bty="n")
text(x=-4200, y=1, labels="b", font = 2, cex = 1.2)


dev.off()








######### FIG S3 -  CORRELATION BETWEEN DEMOGRAPHY AND PALAEOCLIMATE ############
#################################################################################

# create additional ad hoc palettes for the following figures
pal<-scico(19, alpha = NULL, begin = 0, end = 1, direction = 1, palette = "bamako")
pal2<-scico(19, alpha = NULL, begin = 0, end = 1, direction = 1, palette = "vik")
palNorm<-scico(20, alpha = 0.8, begin = 0, end = 1, direction = 1, palette = "oleron")

pdf(file="FigS3.pdf", width=12, height=9) 
layout(matrix(c(1,2,3), 3, 1, byrow=TRUE), widths=8.5, heights=c(2, 2, 2.3))

#first block
par(mar=c(4, 6, 0.3, 0.5)) #c(bottom, left, top, right)
xticks <- seq(-2100,-300,100)

Kuna_mean_100_norm<-(Kuna_mean_100[25:43]-min(Kuna_mean_100[25:43]))/(max(Kuna_mean_100[25:43])-min(Kuna_mean_100[25:43]))
Kuna_aor_norm<-(sites_no0_BlockSumWeights[25:43]-min(sites_no0_BlockSumWeights[25:43]))/(max(sites_no0_BlockSumWeights[25:43])-min(sites_no0_BlockSumWeights[25:43]))
Kuna_area_norm<-(sites_no0_BlockAreaSums[25:43]-min(sites_no0_BlockAreaSums[25:43]))/(max(sites_no0_BlockAreaSums[25:43])-min(sites_no0_BlockAreaSums[25:43]))

plot(Kuna_mean_100_norm, lty="solid", col="black", cex.axis=0.9, xaxt="n",type="l", xlab="",  xlim=c(-2100,-300), ylim=c(0,1), ylab="Normalised values", cex.lab=1.4)

lines(seq(-2100,-300, 100),Kuna_mean_100_norm,col=pal2[3], type="l", lwd=3)
lines(seq(-2100,-300, 100),Kuna_aor_norm, col=pal[17], lwd=3.5)
lines(seq(-2100,-300, 100),Kuna_area_norm,col=palNorm[5], lwd=3.5)

abline(v=seq(-2100,-300,100), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,1,0.2), lwd=0.8, lty="dotted", col="grey80")

axis(side=1, at=xticks, labels=xticks, las=2, cex.axis=1.1)

legend(x=-2100, y=0.4, legend=c("Kuna Ba Cave","Aoristic sum","Minimum area (Ha)"),lty=c("solid","solid","solid"), lwd=c(4,4,4), col=c(pal2[3], pal[17], palNorm[5]), cex=1.3, bg="transparent", bty="n")
text(x=-2125, y=0.9, labels="a", font = 2, cex = 1.25)



# second block
box()
par(mar=c(4, 6, 0.3, 0.5)) #c(bottom, left, top, right)
xticks <- seq(-4000,-500,500)

Zer_mean_500_norm<-(Zeribar_mean_500[2:9]-min(Zeribar_mean_500[2:9]))/(max(Zeribar_mean_500[2:9])-min(Zeribar_mean_500[2:9]))
Zer_aor_norm<-(blockWeight500_4Zer-min(blockWeight500_4Zer))/(max(blockWeight500_4Zer)-min(blockWeight500_4Zer))
Zer_area_norm<-(blockArea500_4Zer-min(blockArea500_4Zer))/(max(blockArea500_4Zer)-min(blockArea500_4Zer))

plot(Zer_mean_500_norm, lty="solid", col="black", cex.axis=0.9, xaxt="n",type="l", xlab="",  xlim=c(-4000,-500), ylim=c(0,1), ylab="Normalised values", cex.lab=1.4)

lines(seq(-4000,-500, 500),Zer_mean_500_norm,col=pal2[16], type="l", lwd=3)
lines(seq(-4000,-500, 500),Zer_aor_norm, col=pal[17], lwd=3.5)
lines(seq(-4000,-500, 500),Zer_area_norm,col=palNorm[5], lwd=3.5)

abline(v=seq(-4000,-500,500), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,1,0.2), lwd=0.8, lty="dotted", col="grey80")

axis(side=1, at=xticks, labels=xticks, las=2, cex.axis=1.1)


legend(x=-4000, y=0.8, legend=c("Lake Zeribar","Aoristic sum","Minimum area (Ha)"),lty=c("solid","solid","solid"), lwd=c(4,4,4), col=c(pal2[16], pal[17], palNorm[5]), cex=1.3, bg="transparent", bty="n")
text(x=-4050, y=0.9, labels="b", font = 2, cex = 1.2)


# third block
box()
par(mar=c(8, 6, 0.3, 0.5)) #c(bottom, left, top, right)
xticks <- seq(-4100,-100,500)

Mir_mean_500_norm<-(Mirabad_mean_500-min(Mirabad_mean_500))/(max(Mirabad_mean_500)-min(Mirabad_mean_500))
Mir_aor_norm<-(blockWeight500_4Mir-min(blockWeight500_4Mir))/(max(blockWeight500_4Mir)-min(blockWeight500_4Mir))
Mir_area_norm<-(blockArea500_4Mir-min(blockArea500_4Mir))/(max(blockArea500_4Mir)-min(blockArea500_4Mir))

plot(Mir_mean_500_norm, lty="solid", col="white", cex.axis=0.9, xaxt="n",type="l", xlab="",  xlim=c(-4100,-100), ylim=c(0,1), ylab="Normalised values", cex.lab=1.4)

lines(seq(-4100,-100, 500),Mir_mean_500_norm,col=pal2[7], type="l", lty=2, lwd=3)
lines(seq(-4100,-100, 500),Mir_aor_norm, col=pal[17], lwd=3.5)
lines(seq(-4100,-100, 500),Mir_area_norm,col=palNorm[5], lwd=3.5)

abline(v=seq(-4000,-500,500), lwd=0.8, lty="dotted", col="grey70")
abline(h=seq(0,1,0.2), lwd=0.8, lty="dotted", col="grey80")

axis(side=1, at=xticks, labels=xticks, las=2, cex.axis=1.1)

legend(x=-3600, y=1, legend=c("Lake Mirabad","Aoristic sum","Minimum area (Ha)"),lty=c(2,1,1), lwd=c(4,4,4), col=c(pal2[7], pal[17], palNorm[5]), cex=1.3, bg="transparent", bty="n")
text(x=-4150, y=0.9, labels="c", font = 2, cex = 1.2)

mtext("BCE/CE",1, 5.3, at=-2200, adj=0, font=2, cex=1.12, las=1)

dev.off()








###########################################
###############  END OF CODES #############
###########################################










