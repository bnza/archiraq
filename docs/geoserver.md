# GeoServer

## Security
### Users, Groups, and Roles

User, groups and roles are stored inside the archiraq postgres db

Add [new](https://docs.geoserver.org/stable/en/user/security/webadmin/ugr.html#add-new-jdbc-user-group-service) JDBC role service ```archiraq_role_service```. The connection URL must be in the form ```jdbc:postgresql://[host]:[port]/[dbname]?currentSchema=admin``` pointing to archiraq db.

Add [new](https://docs.geoserver.org/stable/en/user/security/webadmin/ugr.html#add-new-jdbc-role-service) JDBC user/group service ```archiraq_user_group_service```. The connection URL must be in the form ```jdbc:postgresql://[host]:[port]/[dbname]?currentSchema=admin``` pointing to archiraq db.

Change the ```default``` [authentication provider](https://docs.geoserver.org/stable/en/user/security/webadmin/auth.html#authentication-providers) to point to the ```archiraq_user_group_service``` created in the previous point.

## Jetty

Default GeoServer comes with [Jetty](https://www.eclipse.org/jetty/) web server bundled

### CORS

Archiraq web app uses Cross-Origin Resource Sharing ([CORS](https://developer.mozilla.org/it/docs/Web/HTTP/CORS)) mechanism and [HTTP Basic authorization](https://developer.mozilla.org/en-US/docs/Web/HTTP/Authentication#Basic_authentication_scheme) through GoeServer ```Basic``` [authentication filter](https://docs.geoserver.org/stable/en/user/security/webadmin/auth.html#authentication-filters)

As stated in the official Jetty [docs](https://www.eclipse.org/jetty/documentation/current/cross-origin-filter.html) In order to to enable cross-site HTTP requests you should edit the ```webapps/geoserver/WEB-INF/web.xml``` in your ```$GEOSERVER_HOME``` this way:
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