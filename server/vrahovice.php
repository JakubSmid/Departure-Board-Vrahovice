<?php

$dep = new Departures("https://idos.idnes.cz/vlaky/odjezdy/vysledky/?f=Vrahovice");
print($dep->train_num() . "  " . $dep->destination() . "\n");
print($dep->via() . "\n");
print($dep->time() . "\n");
print($dep->delay() . "\n\n");

$dep->n = 1;
print($dep->train_num() . "  " . $dep->destination() . "\n");
print($dep->via() . "\n");
print($dep->time() . "\n");
print($dep->delay() . "\n\n");


class Departures {
  public $n;
  public $html;

  function __construct($url, $n=0) {
    require_once('simple_html_dom.php');
    $this->n = $n;
    $this->html = file_get_html($url);
  }
  
  function destination() {
    $first_row = $this->html->find(".dep-row", 2*$this->n);
    return $first_row->find("td[title=Cílová stanice] h3", 0)->innertext;
  }
  
  function via() {
    $second_row = $this->html->find(".dep-row", 2*$this->n+1);
    if (!$second_row->find("span[title=projíždí přes]"))
      return null;
    else {
      $raw = trim($second_row->find("span[title=projíždí přes]", 0)->innertext);
      return preg_replace('!\s+!', ' ', $raw); // replace multiple spaces with single space
    }
  }
  
  function train_num() {
    $first_row = $this->html->find(".dep-row", 2*$this->n);
    if (strpos($first_row->find(".desc", 0), "náhradní autobusová doprava\"") !== false)
      // train cancellation
      return "Nahradni BUS";
    else
      return trim($first_row->find("h3", 1)->innertext);
  }
  
  function time() {
    $first_row = $this->html->find(".dep-row", 2*$this->n);
    $departure = $first_row->find("h3", 2);
    if($departure->find("span"))
    {
       // contains two spans - time and date of the next day
       $date = trim($departure->find("span", 1)->innertext);
       $departure->find("span", 1)->outertext = "";
       return trim($departure->find("span", 0)->innertext);
    }
    else
    {
      // contains only time - departure is today
      return $departure->innertext;
    }
  }
  
  function delay() {
    $second_row = $this->html->find(".dep-row", 2*$this->n+1);
    if (!$second_row->find("a.delay-bubble"))
      return null;
    else {
      $delay = $second_row->find("a.delay-bubble", 0)->innertext;
      $delay = str_replace("Aktuální zpoždění ", "", $delay);
      
      if ($delay == "Aktuálně bez zpoždění" || $delay == "Nepředpokládá se zpoždění")
      	print "Bez zpoždění";
      elseif (strpos($delay, "minut") !== false)
      	print "Zpoždění " . $delay;
      else
     	print $delay;
    }
  }
}

function svatek(){
    $m = array();
    $m[1] = array( "", 'Nový rok', 'Karina', 'Radmila', 'Diana', 'Dalimil', 'Tři králové', 'Vilma', 'Čestmír', 'Vladan', 'Břetislav', 'Bohdana', 'Pravoslav', 'Edita', 'Radovan', 'Alice', 'Ctirad', 'Drahoslav', 'Vladislav', 'Doubravka', 'Ilona', 'Běla', 'Slavomír', 'Zdeněk', 'Milena', 'Miloš', 'Zora', 'Ingrid', 'Otýlie', 'Zdislava', 'Robin', 'Marika');
    $m[2] = array( "", 'Hynek', 'Nela a Hromnice', 'Blažej', 'Jarmila', 'Dobromila', 'Vanda', 'Veronika', 'Milada', 'Apolena', 'Mojmír', 'Božena', 'Slavěna', 'Věnceslav', 'Valentýn', 'Jiřina', 'Ljuba', 'Miloslava', 'Gizela', 'Patrik', 'Oldřich', 'Lenka', 'Petr', 'Svatopluk', 'Matěj', 'Liliana', 'Dorota', 'Alexandr', 'Lumír', 'Horymír');
    $m[3] = array( "", 'Bedřich', 'Anežka', 'Kamil', 'Stela', 'Kazimír', 'Miroslav', 'Tomáš', 'Gabriela', 'Františka', 'Viktorie', 'Anděla', 'Řehoř', 'Růžena', 'Rút a Matylda', 'Ida', 'Elena a Herbert', 'Vlastimil', 'Eduard', 'Josef', 'Světlana', 'Radek', 'Leona', 'Ivona', 'Gabriel', 'Marián', 'Emanuel', 'Dita', 'Soňa', 'Taťána', 'Arnošt', 'Kvido');
    $m[4] = array( "",'Hugo', 'Erika', 'Richard', 'Ivana', 'Miroslava', 'Vendula', 'Heřman a Hermína', 'Ema', 'Dušan', 'Darja', 'Izabela', 'Julius', 'Aleš', 'Vincenc', 'Anastázie', 'Irena', 'Rudolf', 'Valérie', 'Rostislav', 'Marcela', 'Alexandra', 'Evžénie', 'Vojtěch', 'Jiří', 'Marek', 'Oto', 'Jaroslav', 'Vlastislav', 'Robert', 'Blahoslav');
    $m[5] = array( "",'Svátek práce', 'Zikmund', 'Alexej', 'Květoslav', 'Klaudie', 'Radoslav', 'Stanislav', 'Statní svátek - Ukončení II. světové války', 'Ctibor', 'Blažena', 'Svatava', 'Pankrác', 'Servác', 'Bonifác', 'Žofie', 'Přemysl', 'Aneta', 'Nataša', 'Ivo', 'Zbyšek', 'Monika', 'Emil', 'Vladimír', 'Jana', 'Viola', 'Filip', 'Valdemar', 'Vilém', 'Maxim', 'Ferdinand', 'Kamila');
    $m[6] = array( "",'Laura', 'Jarmil', 'Tamara', 'Dalibor', 'Dobroslav', 'Norbert', 'Iveta', 'Medard', 'Stanislava', 'Gita', 'Bruno', 'Antonie', 'Antonín', 'Roland', 'Vít', 'Zbyněk', 'Adolf', 'Milan', 'Leoš', 'Květa', 'Alois', 'Pavla', 'Zdeňka', 'Jan', 'Ivan', 'Adriana', 'Ladislav', 'Lubomír', 'Petr a Pavel', 'Šárka');
    $m[7] = array( "",'Jaroslava', 'Patricie', 'Radomír', 'Prokop', 'Státní svátek, Cyril a Metoděj', 'Státní svátek, Mistr Jan Hus', 'Bohuslava', 'Nora', 'Drahoslava', 'Libuše a Amálie', 'Olga', 'Bořek', 'Markéta', 'Karolína', 'Jindřich', 'Luboš', 'Martina', 'Drahomíra', 'Čeněk', 'Ilja', 'Vítězslav', 'Magdaléna', 'Libor', 'Kristýna', 'Jakub', 'Anna', 'Věroslav', 'Viktor', 'Marta', 'Bořivoj', 'Ignác');
    $m[8] = array( "",'Oskar', 'Gustav', 'Miluše', 'Dominik', 'Kristián', 'Oldřiška', 'Lada', 'Soběslav', 'Roman', 'Vavřinec', 'Zuzana', 'Klára', 'Alena', 'Alan', 'Hana', 'Jáchym', 'Petra', 'Helena', 'Ludvík', 'Bernard', 'Johana', 'Bohuslav', 'Sandra', 'Bartoloměj', 'Radim', 'Luděk', 'Otakar', 'Augustýn', 'Evelína', 'Vladěna', 'Pavlína');
    $m[9] = array( "",'Linda a Samuel', 'Adéla', 'Bronislav', 'Jindřiška', 'Boris', 'Boleslav', 'Regína', 'Mariana', 'Daniela', 'Irma', 'Denisa', 'Marie', 'Lubor', 'Radka', 'Jolana', 'Ludmila', 'Naděžda', 'Kryštof', 'Zita', 'Oleg', 'Matouš', 'Darina', 'Berta', 'Jaromír', 'Zlata', 'Andrea', 'Jonáš', 'Václav', 'Michal', 'Jeroným');
    $m[10] = array( "",'Igor', 'Olívie a Oliver', 'Bohumil', 'František', 'Eliška', 'Hanuš', 'Justýna', 'Věra', 'Štefan a Sára', 'Marina', 'Andrej', 'Marcel', 'Renáta', 'Agáta', 'Tereza', 'Havel', 'Hedvika', 'Lukáš', 'Michaela', 'Vendelín', 'Brigita', 'Sabina', 'Teodor', 'Nina', 'Beáta', 'Erik', 'Šarlota a Zoe', 'Statní svátek - Vznik Československa', 'Silvie', 'Tadeáš', 'Štěpánka');
    $m[11] = array( "",'Felix', 'Památka zesnulých', 'Hubert', 'Karel', 'Miriam', 'Liběna', 'Saskie', 'Bohumír', 'Bohdan', 'Evžen', 'Martin', 'Benedikt', 'Tibor', 'Sáva', 'Leopold', 'Otmar', 'Mahulena', 'Romana', 'Alžběta', 'Nikola', 'Albert', 'Cecílie', 'Klement', 'Emílie', 'Kateřina', 'Artur', 'Xenie', 'René', 'Zina', 'Ondřej');
    $m[12] = array( "",'Iva', 'Blanka', 'Svatoslav', 'Barbora', 'Jitka', 'Mikuláš', 'Ambrož', 'Květoslava', 'Vratislav', 'Julie', 'Dana', 'Simona', 'Lucie', 'Lýdie', 'Radana', 'Albína', 'Daniel', 'Miloslav', 'Ester', 'Dagmar', 'Natálie', 'Šimon', 'Vlasta', 'Adam a Eva, Štědrý den', '1. svátek vánoční', 'Štěpán, 2. svátek vánoční', 'Žaneta', 'Bohumila', 'Judita', 'David', 'Silvestr');
    
    return $m[idate("m")][idate("d")];
}
?>
