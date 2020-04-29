# Web system for emergency management - Sistema informativo per la gestione delle emergenze a scala comunale

Next documentation is in Italian because the system has been developed for an Italian public administration.

## Author

[Gter srl](http://www.gter.it) - +39 010 - 

## Introduzione

![alt text](dashboard.png)

Da alcuni anni la Protezione Civile del Comune di Genova ha deciso di dotarsi di un proprio sistema informativo per la gestione delle emergenze. In questo contesto, l’informazione territoriale gioca un ruolo fondamentale. Si tratta du un applicativo web che permette la condivisione delle informazioni fra i vari soggetti sia interni al Comune che esterni (volontari di protezione civile, aziende municipalizzate, VVF, Regione, etc) coinvolti a vario titolo nella gestione delle emergenze e quindi di supportare le operazioni di gestione e mitigazione del rischio. Tale sistema, inizialmente realizzato dal Comune di Genova con risorse interne quale replica di altri sistemi informativi in dotazione all’Ente è stato recentemente completamente rinnovato grazie a dei finanziamenti PON Metro 2014-2020. Il nuovo sistema, realizzato da [Gter srl](http://www.gter.it) , oltre ad aver subito un importante restyling grafico che, a detta degli operatori di protezione civile, ha permesso di incrementarne sostanzialmente l’usabilità, ha ora al centro l’aspetto territoriale. Ogni segnalazione e/o intervento svolto è infatti georeferenziato grazie al collegamento con la toponomastica comunale. Questo nuovo approccio permette di avere in ogni istante un quadro preciso di quanto sta avvenendo sul territorio e pertanto di ottimizzare la gestione delle poche risorse a disposizione. Collegato alle banche dati territoriali, non solo alla toponomastica, ma anche all’anagrafe, e ai principali elementi a rischio (rii, sottopassi etc), il sistema permette di gestire e registrare interventi puntuali quali sgomberi o interdizioni all’accesso in maniera sicura ed efficiente.

## Dipendenze
Ci sono alcune librerie che sono state aggiunte come dipendenze. Si tratta di altri repository github che sono direttamente caricati dentro il repo:

Un esempio è la libreria highcharts per realizzare grafici:

Con il comando ```git submodule```  si aggiunge il repository: 

```
git submodule add https://github.com/highcharts/highcharts.git vendor/highcharts
```


Quindi si può aggiornare  ad una specifica versione

```
git submodule update --remote vendor/highcharts
cd vendor/highcharts 
git checkout v8.0.4
```

## Altro

to do ...


## Copyleft and License

This web page was developed starting from [Start Bootstrap](http://startbootstrap.com/) - [SB Admin 2](http://startbootstrap.com/template-overviews/sb-admin-2/)
[![CDNJS](https://img.shields.io/cdnjs/v/startbootstrap-sb-admin-2.svg)](https://cdnjs.com/libraries/startbootstrap-sb-admin-2)
[SB Admin 2](http://startbootstrap.com/template-overviews/sb-admin-2/) is an open source, admin dashboard template for [Bootstrap](http://getbootstrap.com/) created by [Start Bootstrap](http://startbootstrap.com/).
which  use the following license: Copyright 2013-2018 Blackrock Digital LLC. Code released under the [MIT](https://github.com/BlackrockDigital/startbootstrap-sb-admin-2/blob/gh-pages/LICENSE) license.

Start Bootstrap was created by and is maintained by **[David Miller](http://davidmiller.io/)**, Owner of [Blackrock Digital](http://blackrockdigital.io/).

* https://twitter.com/davidmillerskt
* https://github.com/davidtmiller

Start Bootstrap is based on the [Bootstrap](http://getbootstrap.com/) framework created by [Mark Otto](https://twitter.com/mdo) and [Jacob Thorton](https://twitter.com/fat).


[Gter srl](http://wwww.gter.it) change the license to GPL v.3 (see license file attached)

This work is financed by [PON Metro 2014-2020](http://www.ponmetro.it) funding.

![alt text](./img/pon_metro/Barra_loghi.png)
