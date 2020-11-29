<?php

include "broker-baze.php";

$broker=Broker::getBroker();


if(isset($_GET["metoda"])){
    if($_GET["metoda"]=="vrati sve"){
        $datum=$_POST["datum"];
        $broker->vratiPregled($datum);
        posalji($broker);
    }
    if($_GET["metoda"]=="vrati doktore"){
        $broker->vratiDoktoreZaPregled();
        posalji($broker);
    }
    if($_GET["metoda"]=="vrati pacijente"){
        $broker->vratiPacijenteZaPregled();
        posalji($broker);
    }
}

//Mozda moze da se obrise prvi if pogledati posle
if(isset($_POST["metoda"])){
    if($_POST["metoda"]=="dodaj"){

        $datum=$_POST["datum"];
        $simptomi=$_POST["simptomi"];
        $id_pacijenta=$_POST["id_pacijenta"];
        $id_doktora=$_POST["id_doktora"];

        /*if(!validirajKnjigu($naziv,$kategorija,$brojStrana)){
            echo "Knjiga nije validna";
        }else{*/
            $broker->kreirajPregled($datum,$id_doktora,$id_pacijenta, $simptomi);
            if(!$broker->getRezultat()){
                echo "Nastala je greška u bazi";
            }else{
                echo "Uspešno je dodat novi pregled";
            }
        
    }}



    function posalji($broker){
        $rezultat=$broker->getRezultat();
        $response=array();
        if(!$rezultat){
            $response["status"]="greska u bazi";
            
        }else{
            $response["status"]="ok";
            $response["data"]=array();
            while($red=$rezultat->fetch_object()){
                $response["data"][]=$red;
            }
        }
        echo json_encode($response);
    }
    
    /*function validirajKnjigu($naziv,$kategorija,$brojStrana){
        $naziv=trim($naziv);
        $kategorija=trim($kategorija);
        $brojStrana=trim($brojStrana);
        return strlen($naziv)>3 && strlen($naziv)<40 && intval($kategorija) && intval($brojStrana);
    }*/



?>