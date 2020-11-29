<?php
class Broker{

    private $hostname="localhost";
    private $username="root";
    private $password="";
    private $rezultati;
    private $dbname;
    private $dblink;
    private $affected;
    private static $broker;

    //Konstruktror
    private function __construct(){
        $this->dblink = new mysqli($this->hostname=$hostname, $this->username=$username, $this->password=$password, $this->dbname=$dbname);
        if($this->dblink->connect_errno)
        exit();
        $this->dblink->set_charset("utf8");
    }


    public function getRezultati(){
        return $this->rezultat;
    }
    public function getMysqli(){
        return $this->dblink;
    }
    public static function getBroker(){
        if(!isset($broker)){
            $broker=new Broker();
        }
        return $broker;
    }
    //Proveriti posle ovu funkciju 
    private function izvrsiUpit($upit){
        $this->rezultat=$this->dblink>query($upit);
    }


//Funkcije za prikaz
    public function vratiSveDoktore(){
        $this->izvrsiUpit("select d.id as 'ID', d.ime as 'Ime', d.prezime as 'Prezime', d.jmbg as 'JMBG', kat.naziv as 'Kategorija' from doktori d inner join kategorijedoktora kat on (kat.id=d.idkategorije)");
    }
    public function vratiSvePacijente(){
        $this->izvrsiUpit("select id as 'ID', ime as 'Ime', prezime as 'Prezime', jmbg as 'JMBG' from pacijenti");
    }
    public function vratiPregled($datum){
        $this->izvrsiUpit("select pregled.datum as 'Datum', pregled.simptomi as 'Simptomi', concat(d.ime, ' ', d.prezime) as 'Doktor', concat(p.ime, ' ', p.prezime) as 'Pacijent' from pregledi pregledi inner join doktori d on (pregledi.iddoktora=d.id) inner join p on(pregledi.idpacijenta=p.id) where predgled.datum=".$datum);
    }
    public function vratiSpecijaliste(){
        $this->izvrsiUpit("select * from kategorijedoktora");
    }
    public function vratiDoktoreZaPregled(){
        $this->izvrsiUpit("select id, concat(ime, ' ', prezime) from doktori");
    }
    public function vratiPacijenteZaPregled(){
        $this->izvrsiUpit("select id, concat(ime, ' ', prezime) from pacijenti");
    }

//Funkcije za kreiranje
    public function kreirajDoktora($ime,$prezime,$jmbg, $specijalista){
        $this->izvrsiUpit("insert into doktori (ime, prezime, jmbg, idkategorije) values ('".$ime."',".$prezime.", ".$jmbg.",".$specijalista.")");
    }
    public function kreirajPacijenta($ime,$prezime,$jmbg){
        $this->izvrsiUpit("insert into pacijenti (ime, prezime, jmbg) values ('".$ime."',".$prezime.", ".$jmbg.")");
    }
    public function kreirajPregled($datum,$id_doktora, $id_pacijenta,$simptomi){
        $this->izvrsiUpit("insert into pregledi (datum, idpacijenta, iddoktora, simptomi) values ('".$datum."',".$id_doktora.", ".$id_pacijenta.",".$simptomi.")");
    }

//Funkcije za izmenu
    public function izmeniDoktora($id,$ime,$prezime,$jmbg, $specijalista){
        $this->izvrsiUpit("update doktori set ime='".$ime."', prezime=".$prezime.", jmbg=".$jmbg.", idkategorije=".$specijalista." where id=".$id);
    }
    public function izmeniPacijenta($id,$ime,$prezime,$jmbg){
        $this->izvrsiUpit("update knjiga set ime='".$ime."', prezime=".$prezime.", jmbg=".$jmbg." where id=".$id);
    }
//Funkcije za brisanje
    public function obrisiDoktora($id){
        $this->izvrsiUpit("delete from doktori where id=".$id);
    }
    public function obrisiPacijenta($id){
        $this->izvrsiUpit("delete from pacijenti where id=".$id);
    }
}
?>