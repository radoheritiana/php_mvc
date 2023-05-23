<?php

namespace App\Model;

use App\Core\Connexion;


abstract class Model extends Connexion
{
    /**
     * nom de la table
     *
     * @var string
     */
    protected string $table;

    private $connexion;

    /**
     * exectution d'une requete
     *
     * @param string $sql
     * @param array|null $attributs
     */
    public function request(string $sql, array $attributs = null)
    {
        $this->connexion = Connexion::getInstance();

        if($attributs !== null) {
            $query = $this->connexion->prepare($sql);
            $query->execute($attributs);
            return $query;
        }else{
            return $this->connexion->query($sql);
        }
    }

    /**
     * recuperer tous les lignes d'une tables
     *
     * @return array
     */
    public function findAll(): array
    {
        $query = $this->request('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    /**
     * recuperation des lignes d'une table selon des critères précis
     *
     * @param array $criteres
     * @return array
     */
    public function findBy(array $criteres): array
    {
        $champs = [];
        $valeurs = [];

        foreach ($criteres as $champ => $valeur) {
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }
        $liste_champs = implode(' AND ', $champs);

        return $this->request("SELECT * FROM " . $this->table . " WHERE " . $liste_champs, $valeurs)->fetchAll();
    }

    /**
     * recuperer une ligne par son identifiant
     *
     * @param integer $id
     * @return array
     */
    public function find(int $id): array
    {
        return $this->request("SELECT * FROM " . $this->table . " WHERE id = " . $id)->fetch();
    }

    public function create(Model $model)
    {
        $champs = [];
        $intermediaire = [];
        $valeurs = [];

        foreach ($model as $champ => $valeur) {
            if($valeur !== null && $champ != "db" && $champ != "table")
            {
                $champs[] = $champ;
                $intermediaire[] = "?";
                $valeurs[] = $valeur;
            }
        }
        $liste_champs = implode(',', $champs);
        $liste_intermediarire = implode(',', $intermediaire);
        return $this->
            request("INSERT INTO " . $this->table . " ( " . $liste_champs . ") VALUES (" . $liste_intermediarire . ")",
            $valeurs );
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            // ucfirst : make fist caracter of the string uppercase
            $setter = 'set'.ucfirst($key);

            if (method_exists($this, $setter))
            {
                $this->$setter($value);
            }
        }
        return $this;
    }

    public function update(int $id, Model $model)
    {
        $champs = [];
        $valeurs = [];

        foreach ($model as $champ => $valeur) {
            if($valeur !== null && $champ !== "db" && $champ !== "table")
            {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $id;

        $liste_champs = implode(',', $champs);

        return $this->request("UPDATE " . $this->table . " SET " . $liste_champs . " WHERE id = ?", $valeurs);
    }

    public function delete(int $id)
    {
        return $this->request("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }
}