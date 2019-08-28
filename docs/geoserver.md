# GeoServer

## Workspaces

Add ```archiraq``` workspace with the following information:

Name: ```archiraq```  
Namespace URI: ```http://archiraq.orientlab.net```  
Check it as **Default Workspace**

## Stores

Add ```main_geo_db``` store using ```PostGIS Database``` Vector Data Source

Workspace: ```archiraq```  
Data Source Name: ```main_geo_db```  
Check it as **Enabled**

Fill the right connection parameters (host, port, database, username e password). Set ```geom``` as default schema.
Check **Expose primary keys**

## Layers

Add following layers from ```main_geo_db```:

### Admin boundaries
#### Admbnd0

Name: ```admbnd0```  
Enabled: ```true```  
Advertised : ```true```
Title: ```admbnd0```  
Abstract: ```Administrative boundaries (level 0 -> nations)```

#### Admbnd1

Name: ```admbnd1```  
Enabled: ```true```  
Advertised : ```true```
Title: ```admbnd1```  
Abstract: ```Administrative boundaries (level 1 -> governorates)```

#### Admbnd2

Name: ```admbnd2```  
Enabled: ```true```  
Advertised : ```true```
Title: ```admbnd2```  
Abstract: ```Administrative boundaries (level 2 -> districts)```

### Archaeological data
#### Remote sensing sites (point)

Name: ```vw_site_rs_point```  
Enabled: ```true```  
Advertised : ```true```
Title: ```Remote sensing (point)```  
Abstract: ```Iraqi archaeological remote sensing sites (points)```

#### Remote sensing sites (polygon)

Name: ```vw_site_rs_poly```  
Enabled: ```true```  
Advertised : ```true```
Title: ```Remote sensing (polygon)```  
Abstract: ```Iraqi archaeological remote sensing sites (polygon)```

#### Survey sites (point)

Name: ```vw_site_survey_point```  
Enabled: ```true```  
Advertised : ```true```
Title: ```Survey (point)```  
Abstract: ```Iraqi archaeological survey sites (points)```

#### Survey sites (polygon)

Name: ```vw_site_survey_poly```  
Enabled: ```true```  
Advertised : ```true```
Title: ```Survey (polygon)```  
Abstract: ```Iraqi archaeological survey sites (polygon)```

## Security
### Users, Groups, and Roles

User, groups and roles are stored inside the archiraq postgres db

Add [new](https://docs.geoserver.org/stable/en/user/security/webadmin/ugr.html#add-new-jdbc-user-group-service) JDBC role service ```archiraq_role_service```. The connection URL must be in the form ```jdbc:postgresql://[host]:[port]/[dbname]?currentSchema=admin``` pointing to archiraq db.

Add [new](https://docs.geoserver.org/stable/en/user/security/webadmin/ugr.html#add-new-jdbc-role-service) JDBC user/group service ```archiraq_user_group_service```. The connection URL must be in the form ```jdbc:postgresql://[host]:[port]/[dbname]?currentSchema=admin``` pointing to archiraq db.

### Security Settings

Change **Active role service** to ```archiraq_role_service```

### Authentication
#### Authentication Providers

Change the ```default``` [authentication provider](https://docs.geoserver.org/stable/en/user/security/webadmin/auth.html#authentication-providers) to point to the ```archiraq_user_group_service``` created in the previous point.

### Services

Add new Service access rule 

Service: ```wfs```  
Method: ```getFeature```  
Roles: ```ROLE_GUEST```

## Jetty

Default GeoServer comes with [Jetty](https://www.eclipse.org/jetty/) web server bundled

### CORS

Archiraq web app uses Cross-Origin Resource Sharing ([CORS](https://developer.mozilla.org/it/docs/Web/HTTP/CORS)) mechanism and [HTTP Basic authorization](https://developer.mozilla.org/en-US/docs/Web/HTTP/Authentication#Basic_authentication_scheme) through GoeServer ```Basic``` [authentication filter](https://docs.geoserver.org/stable/en/user/security/webadmin/auth.html#authentication-filters)

As stated in the official Jetty [docs](https://www.eclipse.org/jetty/documentation/current/cross-origin-filter.html) in order to to enable cross-site HTTP requests you should edit the ```webapps/geoserver/WEB-INF/web.xml``` in your ```$GEOSERVER_HOME``` this way:
```$xslt 
<!-- Uncomment following filter to enable CORS -->
<filter>
    <filter-name>cross-origin</filter-name>
    <filter-class>org.eclipse.jetty.servlets.CrossOriginFilter</filter-class>
    <!-- Add following -->
    <init-param>
        <param-name>allowedOrigins</param-name>
        <param-value>*</param-value>
    </init-param>
    <init-param>
        <param-name>allowedMethods</param-name>
        <param-value>GET,POST,HEAD</param-value>
    </init-param>
    <init-param>
        <param-name>allowedHeaders</param-name>
        <param-value>X-Requested-With,Content-Type,Accept,Origin,Authorization</param-value>
    </init-param>
</filter>
<!-- Uncomment following filter to enable CORS -->
<filter-mapping>
    <filter-name>cross-origin</filter-name>
    <url-pattern>/*</url-pattern><!-- /* -->
</filter-mapping>
```
