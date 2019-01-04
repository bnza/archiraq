/* global context, cy */

context('<TheMapContainer>', () => {
    beforeEach(() => {
        cy.server();        // enable response stubbing
        cy.route({
            method: 'GET',      // Route all GET requests
            url: 'http://localhost:8080/geoserver/wfs?service=WFS&version=1.1.0&request=GetFeature&typename=archiraq:admbnd2&outputFormat=application/json&srsname=EPSG:4326*',
            response: {
                'type': 'FeatureCollection',
                'features': [
                    {
                        'type': 'Feature',
                        'id': 'admbnd2.4',
                        'geometry': {
                            'type': 'MultiPolygon',
                            'coordinates': [[[[42.47921753, 35.92361832], [42.51029968, 35.92361832], [42.54138184, 35.92361832], [42.56210327, 35.9132576], [42.57246018, 35.89253998], [42.57246018, 35.8303833], [42.58282089, 35.80966568], [42.61390305, 35.79930878], [42.63462448, 35.78894806], [42.6449852, 35.76823044], [42.65534592, 35.747509], [42.68642807, 35.7371521], [42.72428513, 35.72957993], [42.71751022, 35.76823044], [42.68124771, 35.79412842], [42.65534592, 35.8303833], [42.6449852, 35.9029007], [42.67606735, 35.9132576], [42.70714951, 35.9029007], [42.79003143, 35.9029007], [42.81075287, 35.88218308], [42.8314743, 35.89253998], [42.84183502, 35.9132576], [42.86255646, 35.92361832], [42.88327789, 35.9029007], [42.89363861, 35.88218308], [42.9454422, 35.89253998], [42.96616364, 35.87182236], [42.99724197, 35.87182236], [43.03868485, 35.88218308], [43.03868485, 35.84074402], [43.02832413, 35.8200264], [43.04904556, 35.80966568], [43.04904556, 35.77858734], [43.05940628, 35.75786972], [43.04904556, 35.7371521], [43.03868485, 35.70607376], [43.08012772, 35.70607376], [43.12157059, 35.69571304], [43.11120987, 35.67499542], [43.08012772, 35.66463471], [43.06819534, 35.64297485], [43.03811264, 35.5832634], [43.05267951, 35.55689334], [43.05123344, 35.55561662], [43.04788293, 35.55418559], [43.0443323, 35.55173218], [43.04258058, 35.55005731], [43.03983099, 35.5474452], [43.03722724, 35.5457437], [43.0336444, 35.5446956], [43.02952001, 35.54373325], [43.02631511, 35.54271077], [43.02341966, 35.54254768], [43.0209879, 35.54233283], [43.01808357, 35.54124136], [43.01652006, 35.54013265], [43.01401551, 35.53821055], [43.01078639, 35.53918111], [43.00682056, 35.53724581], [43.00388428, 35.5357866], [43.00153834, 35.53576398], [42.99901626, 35.53564734], [42.99732376, 35.53508317], [42.99563126, 35.53395484], [42.99403278, 35.53263845], [42.9927164, 35.53132206], [42.99177612, 35.53094595], [42.99045973, 35.53075789], [42.98923737, 35.53075789], [42.98745084, 35.53047581], [42.9859464, 35.53075789], [42.98463001, 35.53066387], [42.98378376, 35.53028775], [42.98312556, 35.53000567], [42.98162112, 35.52991164], [42.98077487, 35.5300997], [42.97945848, 35.53038178], [42.97833015, 35.53000567], [42.97757793, 35.52887734], [42.97701376, 35.52774901], [42.97616751, 35.52727887], [42.97475709, 35.52643262], [42.97400487, 35.52577442], [42.97428695, 35.52511623], [42.97475709, 35.52445803], [42.97485112, 35.52379984], [42.97485112, 35.52295359], [42.97391084, 35.52238942], [42.97184223, 35.52210734], [42.97080793, 35.52126109], [42.96930348, 35.52032081], [42.96808112, 35.51966262], [42.96610654, 35.51947456], [42.96450807, 35.51956859], [42.96243946, 35.5189104], [42.96112307, 35.51844026], [42.95802015, 35.51608956], [42.95472918, 35.51524331], [42.95256654, 35.51439706], [42.95068599, 35.51345679], [42.9493696, 35.51185831], [42.94795918, 35.51091804], [42.94664279, 35.51082401], [42.94513835, 35.5104479], [42.94410405, 35.50941359], [42.94222349, 35.50828526], [42.94194141, 35.5080972], [42.94128321, 35.50828526], [42.94053099, 35.50819123], [42.94024891, 35.50781512], [42.94081307, 35.50734498], [42.94128321, 35.50715693], [42.94165932, 35.50668679], [42.9415653, 35.50612262], [42.9409071, 35.50574651], [42.9398728, 35.50612262], [42.93930863, 35.5064047], [42.93912057, 35.50602859], [42.9381803, 35.50593457], [42.9375221, 35.50584054], [42.93742807, 35.50527637], [42.93705196, 35.5047122], [42.93629974, 35.50461818], [42.93507738, 35.50461818], [42.93338488, 35.50518234], [42.93150433, 35.50565248], [42.93094016, 35.5053704], [42.93084613, 35.50452415], [42.93018794, 35.50414804], [42.92924766, 35.50405401], [42.92849544, 35.50395998], [42.92811933, 35.50330179], [42.9273671, 35.50264359], [42.92623877, 35.5019854], [42.92520447, 35.50151526], [42.92482836, 35.50132721], [42.92379405, 35.50038693], [42.92304183, 35.49963471], [42.92210155, 35.49907054], [42.92012697, 35.49897651], [42.91909266, 35.49888248], [42.91824641, 35.49897651], [42.91777627, 35.49991679], [42.91664794, 35.50085707], [42.91551961, 35.50113915], [42.91420322, 35.50095109], [42.91401516, 35.50066901], [42.91439127, 35.49982276], [42.91495544, 35.49907054], [42.91476739, 35.4986004], [42.91363905, 35.49822429], [42.91213461, 35.49831832], [42.9111003, 35.49869443], [42.91034808, 35.49954068], [42.90931378, 35.50057498], [42.90874961, 35.50066901], [42.90715114, 35.50019887], [42.90517655, 35.50001082], [42.903296, 35.50038693], [42.90254378, 35.5002929], [42.90085128, 35.50057498], [42.899911, 35.50142123], [42.89859461, 35.50142123], [42.89803044, 35.50113915], [42.89774836, 35.50057498], [42.89699614, 35.5002929], [42.89530364, 35.50019887], [42.89455142, 35.50001082], [42.89473947, 35.49916457], [42.89549169, 35.49822429], [42.89511558, 35.49718998], [42.89445739, 35.4969079], [42.89323503, 35.4969079], [42.89135447, 35.49624971], [42.89060225, 35.4958736], [42.89032017, 35.4952154], [42.89079031, 35.49483929], [42.89097836, 35.49427512], [42.89069628, 35.49380498], [42.889756, 35.49314679], [42.88890975, 35.49211249], [42.88843961, 35.49145429], [42.88853364, 35.4901379], [42.88919184, 35.48900957], [42.88966197, 35.48806929], [42.88966197, 35.48731707], [42.88937989, 35.48665888], [42.88862767, 35.48609471], [42.88796947, 35.48562457], [42.88759336, 35.48487235], [42.88759336, 35.48430818], [42.88731128, 35.48374401], [42.88599489, 35.48346193], [42.8853367, 35.4833679], [42.88505461, 35.48280374], [42.8846785, 35.48242763], [42.88326809, 35.48289777], [42.88223378, 35.48355596], [42.88110545, 35.48393207], [42.87997711, 35.48393207], [42.87884878, 35.48383804], [42.87797458, 35.48321942], [42.87806392, 35.48179035], [42.8787343, 35.48054537], [42.87883007, 35.47977922], [42.87854276, 35.47872578], [42.8787343, 35.47786387], [42.87921314, 35.47719349], [42.88055389, 35.47700195], [42.88160734, 35.47719349], [42.88246925, 35.47700195], [42.88275655, 35.47594851], [42.88266078, 35.47489506], [42.88275655, 35.47384161], [42.88333116, 35.47307547], [42.88400153, 35.47250086], [42.88486344, 35.4724051], [42.88572535, 35.47307547], [42.88639573, 35.47403315], [42.88764071, 35.47403315], [42.88878993, 35.47317124], [42.88926876, 35.4724051], [42.88955607, 35.47096858], [42.89022644, 35.4700109], [42.89108835, 35.46867015], [42.8921418, 35.46646749], [42.89290794, 35.46560558], [42.89309948, 35.46455213], [42.89329101, 35.46340292], [42.89338678, 35.46215794], [42.89367409, 35.46052988], [42.89415293, 35.4592849], [42.89472753, 35.45813568], [42.89549368, 35.45717801], [42.89635559, 35.45612456], [42.8972175, 35.45487958], [42.89807941, 35.45373036], [42.89865402, 35.45277268], [42.89942016, 35.4512404], [42.899899, 35.44989965], [42.90085668, 35.4485589], [42.90200589, 35.44721815], [42.9028678, 35.44626047], [42.90392125, 35.44463242], [42.90497469, 35.4434832], [42.90564507, 35.44233399], [42.90602814, 35.441089], [42.90593237, 35.43917365], [42.9055493, 35.4378329], [42.90497469, 35.43639638], [42.90420855, 35.4354387], [42.90353818, 35.43457679], [42.90229319, 35.43428949], [42.9001863, 35.43438525], [42.89894132, 35.43419372], [42.89769634, 35.43361911], [42.89664289, 35.4330445], [42.89606828, 35.43208683], [42.89635559, 35.43084184], [42.89673866, 35.4297884], [42.89731327, 35.42921379], [42.89769634, 35.42892648], [42.89760057, 35.42806457], [42.89683443, 35.42691536], [42.89616405, 35.42557461], [42.89568521, 35.42461693], [42.894536, 35.42404232], [42.89338678, 35.42318041], [42.8921418, 35.42222274], [42.89175873, 35.42183966], [42.89041798, 35.42088198], [42.8897476, 35.41982854], [42.88955607, 35.41887086], [42.88965184, 35.41753011], [42.89003491, 35.41657243], [42.89041798, 35.41590206], [42.89070528, 35.41523168], [42.89080105, 35.41408247], [42.89003491, 35.41245441], [42.8894603, 35.41101789], [42.88859839, 35.40967714], [42.88773648, 35.40824063], [42.88687457, 35.4062295], [42.8864915, 35.40393107], [42.88658726, 35.40249455], [42.88697034, 35.4008665], [42.88744917, 35.39971729], [42.88744917, 35.39780193], [42.88773648, 35.39588657], [42.88811955, 35.39406698], [42.88888569, 35.392822], [42.88993914, 35.39157702], [42.89137566, 35.39033204], [42.89300371, 35.38937436], [42.8948233, 35.38851245], [42.89664289, 35.38736323], [42.8975048, 35.38698016], [42.89874978, 35.38630979], [42.89951593, 35.3850648], [42.89980323, 35.38372405], [42.89980323, 35.3823833], [42.89884555, 35.38113832], [42.89760057, 35.37989334], [42.89625982, 35.37874412], [42.89472753, 35.37788221], [42.89396139, 35.376733], [42.89319525, 35.37615839], [42.89309948, 35.37529648], [42.89195026, 35.37491341], [42.89127989, 35.37443457], [42.89060951, 35.37366843], [42.88993914, 35.37280652], [42.889173, 35.37175307], [42.88907723, 35.37098693], [42.889173, 35.36983771], [42.88993914, 35.36840119], [42.89070528, 35.36734775], [42.89137566, 35.36639007], [42.89252487, 35.36524085], [42.89386562, 35.36418741], [42.89549368, 35.36351703], [42.89664289, 35.36246359], [42.89798364, 35.36006939], [42.89932439, 35.35805826], [42.90056937, 35.35604714], [42.90238896, 35.35432332], [42.90382548, 35.3531741], [42.90669852, 35.35135451], [42.90803927, 35.3504926], [42.90966732, 35.34905609], [42.91072077, 35.34819417], [42.91177421, 35.34685342], [42.91206152, 35.34522537], [42.91206152, 35.34321425], [42.91244459, 35.34139466], [42.91311496, 35.33986237], [42.91455148, 35.33871316], [42.91665837, 35.33746817], [42.91886104, 35.33603166], [42.92087216, 35.33459514], [42.92269175, 35.33363746], [42.92499018, 35.33239248], [42.92575632, 35.33153057], [42.92767168, 35.32990251], [42.92920396, 35.32913637], [42.93035318, 35.32827446], [42.93150239, 35.32731678], [42.93293891, 35.32655064], [42.9344712, 35.32568873], [42.93581195, 35.32520989], [42.93724847, 35.32425221], [42.93897229, 35.32406067], [42.94127072, 35.3239649], [42.9425157, 35.3233903], [42.94309031, 35.32252839], [42.94337761, 35.32137917], [42.94490989, 35.32080456], [42.94644218, 35.32109187], [42.9478787, 35.32080456], [42.94826177, 35.32042149], [42.94797447, 35.31888921], [42.94759139, 35.31697385], [42.94768716, 35.31553733], [42.948166, 35.31343044], [42.94902791, 35.31189815], [42.9508475, 35.31103624], [42.95237979, 35.3102701], [42.95429515, 35.30921665], [42.95611473, 35.30797167], [42.95803009, 35.30663092], [42.95937084, 35.30586478], [42.95956238, 35.30442826], [42.95984968, 35.30337481], [42.95908354, 35.3022256], [42.95716818, 35.30184253], [42.95477398, 35.30107638], [42.95429515, 35.2998314], [42.95372054, 35.29791605], [42.9529544, 35.2971499], [42.95266709, 35.29523454], [42.95314593, 35.29331919], [42.95257132, 35.29169113], [42.95237979, 35.28987154], [42.95343323, 35.28853079], [42.95448668, 35.28728581], [42.95649781, 35.28489162], [42.95735972, 35.28335933], [42.95841316, 35.28153974], [42.95879624, 35.28010322], [42.95927507, 35.2783794], [42.95984968, 35.27655981], [42.96080736, 35.2756979], [42.96052006, 35.2754106], [42.9612862, 35.27483599], [42.96243541, 35.27454869], [42.96358463, 35.27406985], [42.96415924, 35.27320794], [42.96415924, 35.27186719], [42.96454231, 35.27052644], [42.96549999, 35.26995183], [42.96655343, 35.26966452], [42.96731958, 35.26880261], [42.96760688, 35.26755763], [42.96731958, 35.26621688], [42.96789418, 35.2652592], [42.96923493, 35.26478036], [42.97105452, 35.26430152], [42.97268258, 35.26382268], [42.97421486, 35.26363115], [42.97603445, 35.26478036], [42.97670483, 35.26573804], [42.97775827, 35.26602535], [42.97967363, 35.26516343], [42.98120592, 35.26458883], [42.98158899, 35.26343961], [42.98072708, 35.26286501], [42.97862018, 35.2622904], [42.97814134, 35.26152426], [42.97833288, 35.26027927], [42.97909902, 35.25913006], [42.98053554, 35.25798084], [42.98139745, 35.25788508], [42.98283397, 35.2572147], [42.98417472, 35.25644856], [42.98474933, 35.25558665], [42.98446202, 35.25434167], [42.98360011, 35.25386283], [42.98225936, 35.25319245], [42.98216359, 35.25194747], [42.98216359, 35.25031942], [42.98111015, 35.24984058], [42.97938633, 35.25012788], [42.97756674, 35.25022365], [42.97622599, 35.2488829], [42.97565138, 35.24744638], [42.97632175, 35.24572256], [42.97603445, 35.24457334], [42.97411909, 35.24428604], [42.9720122, 35.24438181], [42.97086299, 35.24371143], [42.97105452, 35.24294529], [42.97124606, 35.24198761], [42.97134183, 35.24093416], [42.97191643, 35.23940188], [42.97296988, 35.23892304], [42.97373602, 35.2387315], [42.97421486, 35.23739075], [42.97459793, 35.23595424], [42.9744064, 35.23442195], [42.97335295, 35.23327274], [42.9722995, 35.23241082], [42.97249104, 35.23001663], [42.97325718, 35.22858011], [42.97306565, 35.22685629], [42.97182066, 35.22513247], [42.97057568, 35.22340865], [42.96942647, 35.22139752], [42.96913916, 35.22043984], [42.96990531, 35.21938639], [42.97019261, 35.21833295], [42.96913916, 35.21756681], [42.96798995, 35.21718373], [42.96751111, 35.21565145], [42.96722381, 35.21421493], [42.96779841, 35.21229957], [42.96846879, 35.21115036], [42.9693307, 35.20971384], [42.96990531, 35.20846886], [42.97086299, 35.20770272], [42.9717249, 35.20731964], [42.97335295, 35.20636197], [42.97545984, 35.20617043], [42.97794981, 35.20664927], [42.97957786, 35.20741541], [42.98091861, 35.20789425], [42.98254667, 35.20846886], [42.98446202, 35.20885193], [42.98580277, 35.20875616], [42.98666468, 35.20770272], [42.98637738, 35.2068408], [42.98522817, 35.20569159], [42.98446202, 35.20435084], [42.98446202, 35.20329739], [42.98455779, 35.20166934], [42.98532393, 35.20004129], [42.98618584, 35.19870054], [42.98743083, 35.19697671], [42.9878139, 35.1961148], [42.98838851, 35.19391214], [42.98934618, 35.19170948], [42.9904954, 35.1907518], [42.99164461, 35.19036873], [42.99384727, 35.18960259], [42.99518802, 35.18893221], [42.99681608, 35.18835761], [42.99729492, 35.18672955], [42.99710338, 35.18500573], [42.99595417, 35.18395228], [42.99470918, 35.18366498], [42.99336843, 35.18299461], [42.99327267, 35.18174962], [42.99490072, 35.18117502], [42.99633724, 35.18098348], [42.99719915, 35.17954696], [42.99844413, 35.17839775], [42.99988065, 35.17763161], [43.00131717, 35.17753584], [43.00294522, 35.17839775], [43.00533942, 35.17906812], [43.0068717, 35.17906812], [43.00754208, 35.17801468], [43.00696747, 35.17676969], [43.00581826, 35.17590778], [43.00380713, 35.17600355], [43.00189177, 35.17523741], [43.00198754, 35.1743755], [43.00208331, 35.17351359], [43.00246638, 35.17284321], [43.00323252, 35.1722686], [43.00428597, 35.171694], [43.00543519, 35.17140669], [43.00706324, 35.17111939], [43.00830822, 35.171694], [43.00878706, 35.17255591], [43.00888283, 35.17370512], [43.00945744, 35.17485434], [43.01022358, 35.17571625], [43.01098972, 35.17609932], [43.01204317, 35.17590778], [43.01271354, 35.17533318], [43.01233047, 35.1746628], [43.0122347, 35.17370512], [43.01319238, 35.17293898], [43.01395853, 35.17140669], [43.01395853, 35.16977864], [43.01328815, 35.16805482], [43.01300085, 35.1669056], [43.01213894, 35.16518178], [43.01156433, 35.16470294], [43.01022358, 35.16575639], [43.00936167, 35.16700137], [43.00840399, 35.16719291], [43.00706324, 35.1666183], [43.00668017, 35.16470294], [43.00763785, 35.16326643], [43.00917013, 35.16259605], [43.01070242, 35.16211721], [43.01213894, 35.16182991], [43.01376699, 35.16221298], [43.01520351, 35.16288335], [43.01644849, 35.16345796], [43.01855538, 35.16326643], [43.02018344, 35.16278759], [43.02219456, 35.16202144], [43.02410992, 35.16115953], [43.02487606, 35.16087223], [43.02612104, 35.16048916], [43.02707872, 35.16058493], [43.0274618, 35.16087223], [43.02813217, 35.16106376], [43.02832371, 35.16182991], [43.02832371, 35.16288335], [43.02908985, 35.16355373], [43.02966445, 35.16355373], [43.0304306, 35.16250028], [43.0304306, 35.1612553], [43.03052637, 35.15991455], [43.03138828, 35.15838226], [43.03205865, 35.15675421], [43.03215442, 35.15483885], [43.03253749, 35.15301926], [43.03397401, 35.15072084], [43.03454862, 35.14966739], [43.03406978, 35.14823087], [43.03320787, 35.14641128], [43.03349517, 35.14478323], [43.03454862, 35.14353825], [43.03502746, 35.14181442], [43.03588937, 35.14047367], [43.03751742, 35.13961176], [43.03981585, 35.13932446], [43.04106083, 35.13846255], [43.04125237, 35.1371218], [43.04096506, 35.13530221], [43.04010315, 35.13386569], [43.03962431, 35.13252494], [43.0384751, 35.1317588], [43.03770896, 35.13118419], [43.03665551, 35.13070535], [43.0355063, 35.13013074], [43.03521899, 35.12917307], [43.03531476, 35.12783232], [43.03636821, 35.12630003], [43.03646397, 35.12486351], [43.03636821, 35.12419314], [43.03531476, 35.12313969], [43.03426131, 35.12256508], [43.03234596, 35.12218201], [43.03062213, 35.12170317], [43.02976022, 35.12112856], [43.02956869, 35.11978781], [43.02976022, 35.11825553], [43.02889831, 35.11643594], [43.02918562, 35.11557403], [43.02995176, 35.11490365], [43.03138828, 35.11365867], [43.03148405, 35.11193485], [43.0304306, 35.11049833], [43.02937715, 35.10973219], [43.03004753, 35.1079126], [43.03397401, 35.10570994], [43.03627244, 35.10321997], [43.03866664, 35.10235806], [43.03933701, 35.10197499], [43.03972008, 35.10159192], [43.04000739, 35.10101731], [43.04029469, 35.0998681], [43.0411566, 35.09814428], [43.04278465, 35.09680353], [43.0438381, 35.09555854], [43.04431694, 35.09431356], [43.04594499, 35.09335588], [43.04757305, 35.0923982], [43.04872226, 35.09163206], [43.04967994, 35.09057862], [43.05005264, 35.08999313], [42.9973331, 35.0899285], [42.94829852, 35.08975422], [42.86356109, 35.09001222], [42.81739926, 35.08990248], [42.75341312, 35.08993819], [42.71731011, 35.08990076], [42.63935935, 35.08989798], [42.54159578, 35.08996744], [42.50003859, 35.08998212], [42.50002153, 35.03875647], [42.49997826, 34.97365707], [42.491375, 34.972752], [42.447067, 34.967344], [42.4152, 34.963094], [42.356066, 34.955882], [42.31244, 34.950345], [42.278869, 34.946353], [42.273245, 34.945451], [42.243082, 34.959231], [42.210362, 34.973782], [42.195025, 34.980865], [42.162305, 34.976487], [42.126518, 34.971464], [42.081188, 34.965154], [42.031086, 34.958329], [41.9999, 34.95408], [41.870176, 34.99992], [41.85018152, 35.00755676], [41.85758591, 35.02236176], [41.86794663, 35.04307938], [41.87830734, 35.09487534], [41.86794663, 35.11559677], [41.85758591, 35.13631439], [41.86794663, 35.16739273], [41.87830734, 35.18811035], [41.89902878, 35.19847107], [41.9093895, 35.21918869], [41.93011093, 35.22954559], [41.91975021, 35.25026703], [41.95082855, 35.27098465], [41.94047165, 35.33314133], [41.93011093, 35.37457657], [41.94047165, 35.43673325], [41.95082855, 35.46781158], [41.97154999, 35.47816849], [41.96118927, 35.51960754], [41.95082855, 35.54032517], [41.96118927, 35.56104279], [41.97154999, 35.58176422], [41.99227142, 35.59212112], [42.00263214, 35.62319946], [42.02335358, 35.63356018], [42.03371429, 35.6542778], [42.04407501, 35.68535614], [42.06479645, 35.70607376], [42.08551788, 35.71643448], [42.0958786, 35.747509], [42.12696075, 35.75786972], [42.13732147, 35.78894806], [42.15803909, 35.79930878], [42.16839981, 35.8200264], [42.18912125, 35.8303833], [42.20984268, 35.85110474], [42.23056412, 35.86146164], [42.24092484, 35.88218308], [42.27200699, 35.89253998], [42.28236771, 35.9132576], [42.30308914, 35.92361832], [42.32381058, 35.93397903], [42.35489273, 35.97541428], [42.38597107, 35.95469666], [42.41705322, 35.93397903], [42.43777466, 35.92361832], [42.47921753, 35.92361832]]]]
                        },
                        'geometry_name': 'geom',
                        'properties': {
                            'id': 4,
                            'admbnd1_id': 27,
                            'name': 'Hatra',
                            'altname': 'الحضر'
                        }
                    }
                ],
                'totalFeatures': 1,
                'numberMatched': 1,
                'numberReturned': 1,
                'timeStamp': '2019-01-02T15:38:34.197Z',
                'crs': {
                    'type': 'name',
                    'properties': {
                        'name': 'urn:ogc:def:crs:EPSG::4326'
                    }
                }
            }
        });
        cy.visit('http://archiraq.local');
    });

    it('click on feature', () => {
        cy.wait(200);
        cy.get('canvas').trigger('pointerdown',246,100);
        cy.get('canvas').trigger('pointerup',246,100);
        cy.wait(500);
        cy.get('[data-test="map-selected-features-num"]').then($input => {
            expect($input.val()).to.be.equal('1');
        });
        cy.get('canvas').trigger('pointerdown',1,1);
        cy.get('canvas').trigger('pointerup',1,1);
        cy.wait(500);
        cy.get('[data-test="map-selected-features-num"]').then($input => {
            expect($input.val()).to.be.equal('0');
        });
    });
});
