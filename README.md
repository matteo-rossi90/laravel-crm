Laravel-CRM. 

IL progetto mira alla creazione di un CRM (Customers Relationship Management), sistema usato per la gestione del rapporto tra aziende e clienti potenziali e acquisiti. In particolare era richiesto un CRM che desse la possibilità agli utenti di aggiungere, modificare, eliminare e visualizzare aziende e i relativi dipendenti. Era previsto anche che nel modificare o nell'aggiungere le informazioni, il sistema avesse anche un sistema di validazione e di controllo di eventuali errori di inserimento. Inoltre era richiesta anche una sezione statistica che mettesse in evidenza il numero totale delle aziende caricate, dei dipendenti e l'ultima azienda inserita.

Ho sviluppato il progetto seguendo alcune fasi:

1) Creazione del database. In questa fase ho progettato il database e le entità di riferimento, ossia Aziende e Dipendenti. Ho aggiunto anche una tabella Tipologia, in riferimento ai settori delle aziende, anche se non era richiesto specificatamente dalla consegna, perchè ho ritenuto fosse necessario per una questione di completezza di informazioni. Ho poi stabilito delle relazioni One-to-Many tra le entità Aziende e Dipendenti e tra Aziende e Tipologie.
2) Inizializzazione delle tabelle attraverso Laravel. Una volta progettato il DB, ho eseguito le tabelle in Laravel, ho creato i modelli dei dati e ho popolato le tabelle con dati provvisori per testarne le funzionalità e gli effetti visivi
3) Creazione delle funzionalità di gestione delle risorse. Ho visualizzato i dati popolati sulle aziende e sui dipendenti e ho creato un form per aggiungere nuove aziende e nuovi dipendenti e un altro per modificare i dati già inseriti; ho fatto anche in modo di cancellare le risorse.
4) Lato grafico della dashboard. Il layout grafico è stato curato attraverso Orchid, builder di Laravel per creare CRM, dal quale ho sfruttato la possibilità di aggiungere e personalizzare alcuni elementi grafici per velocizzare lo sviluppo del lato visuale.
5) Aggiunta della validazione e delle statistiche. Per ultimo ho aggiunto il controllo dei dati inseriti e da modificare e il calcolo di tutte le aziende, di tutti i dipendenti e dell'ultima azienda caricata.

Tecnologie usate: Laravel, Orchid

Il progetto nasce dalla volontà di consolidare le conoscenze già acquisite sulla creazione della CRUD per la gestione di informazioni che riguardano la creazione di un CRM ed è stato anche un'opportunità per allargare i propri orizzonti sulla programmazione sperimentando un builder come Orchid.
