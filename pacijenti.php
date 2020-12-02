<?php

include "broker-baze.php";

$broker=Broker::getBroker();

//Mozda moze da se obrise prvi if videti posle
if(isset($_GET["metoda"])){
    if($_GET["metoda"]=="vrati sve"){
        $broker->vratiSvePacijente();
        posalji($broker);
    }
}
if(isset($_POST["metoda"])){
    if($_POST["metoda"]=="dodaj"){
        $ime=$_POST["ime"];
        $prezime=$_POST["prezime"];
        $jmbg=$_POST["jmbg"];
        /*if(!validirajPacijenta($ime,$prezime,$jmbg)){
            echo "Pacijent nije validan, proverite da li ste sve dobro uneli";
        }else{*/
            $broker->kreirajPacijenta($ime,$prezime,$jmbg);
            if(!$broker->getRezultat()){
                echo "Nastala je greška u bazi";
            }else{
                echo "Uspešno je dodat novi karton pacijenta";
            }
        
    }
    if($_POST["metoda"]=="izmeni"){
        $id=$_POST["id"];
        $ime=$_POST["ime"];
        $prezime=$_POST["prezime"];
        $jmbg=$_POST["jmbg"];

        /*if(!validirajPacijenta($ime,$prezime,$jmbg)){
            echo "Pacijent nije validan, proverite da li ste sve dobro uneli";
        }else{*/
            $broker->izmeniPacijenta($id,$ime,$prezime,$jmbg);
        if(!$broker->getRezultat()){
                echo "Nastala je greška u bazi";
            }
        else{
                echo "Uspešno je izmenjen karton pacijenta";
            }
        
    }
    if($_POST["metoda"]=="obrisi"){
        $broker->obrisiPacijenta($_POST["id"]);
        if(!$broker->getRezultat()){
            echo "Nastala je greška u bazi";
        }else{
            echo "Uspešno je obrisan karton pacijenta";
        }
    }
}





function posalji($broker){
    $rezultat=$broker->getRezultat();
    $response=array();
    if(!$rezultat){
        $response["status"]="Nastala je greška u bazi";
        
    }else{
        $response["status"]="ok";
        $response["data"]=array();
        while($red=$rezultat->fetch_object()){
            $response["data"][]=$red;
        }
    }
    echo json_encode($response);
}


//Bolje je da za pocetak nemamo ovu funkciju
/*function validirajKnjigu($ime,$prezime,$jmbg){
    $ime=trim($ime);
    $prezime=trim($prezime);
    $jmbg=trim($jmbg;
    return strlen($naziv)>3 && strlen($naziv)<40 && intval($kategorija) && intval($brojStrana);
}*/

?>