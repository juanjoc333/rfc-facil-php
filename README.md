![](logo.png)

# RfcFacil PHP
Librería para calcular el Registro Federal de Contribuyentes en México (RFC) - PHP

## Uso

``` php
   
    //Persona físicas
    $builder = new RfcBuilder();
    
    $rfc = $builder->name('Juan José')
        ->firstLastName('Cortés')
        ->secondLastName('Guzmán')
        ->birthday(3, 9, 1984)
        ->build()
        ->toString();
    
    echo $rfc;
    
    //Personas morales
    $builder = new RfcBuilder();
    
    $rfc = $builder->legalName('AUTOS PULLMAN, S.A. DE C.V.')
         ->creationDate(30, 9, 1964)
         ->build()
         ->toString();
    
    echo $rfc;
```

## Download

Con composer
``` bash
    composer require juanjoc333/rfc-facil-php
```

## Fuente
Esta librería se basa en documentación oficial obtenida por medio del IFAI (Instituto Federal de Acceso a la Información). El documento puede ser consultado en el sitio de [INFOMEX](https://www.infomex.org.mx/gobiernofederal/moduloPublico/moduloPublico.action) con el folio `0610100135506`.

Cabe advertir que sólo la Secretaría de Hacienda y Crédito Público, a través del Servicio de Administración Tributaria, es la única instancia que oficialmente asigna las claves de RFC a los contribuyentes que así lo soliciten, a partir de la aplicación de este procedimiento a la base de datos del Padrón de Contribuyentes, con la finalidad de identificar homonimias y evitar la duplicidad de registros.

## En otros lenguajes
- JAVA [josketres/rfc-facil](https://github.com/josketres/rfc-facil)
- Ruby [acrogenesis/rfc_facil](https://github.com/acrogenesis/rfc_facil)
- NET [migsalazar/RfcFacil](https://github.com/migsalazar/RfcFacil)

## Contribuciones
- Reporta errores o sugerencias en: [https://github.com/juanjoc333/rfc-facil-php/issues](https://github.com/juanjoc333/rfc-facil-php/issues)

## Agradecimientos
RfcFacil PHP es una versión para PHP de la librería [rfc-facil](http://josketres.github.io/rfc-facil/) escrita por [josketres](https://github.com/josketres). 
Gracias!

## Licencia
Licensed under the Apache License, Version 2.0.