<?php

namespace Quotation\Service;


use Illuminate\Database\Capsule\Manager;
use Quotation\Model\Devis\DevisArticle;
use Quotation\Model\Devis\DevisPrestation;

class Devis
{
    /** @var Manager */
    protected $db;

    public function __construct(Manager $db)
    {
        $this->db = $db;
    }

    /**
     * @param int $idDevis
     * @param int $journee
     *
     * @return float
     */
    public function computeTotalDevis($idDevis, $journee = null)
    {
        $where = [
            [ 'id_devis', '=', $idDevis ],
        ];

        if ($journee) {
            $where[] = [ 'journee', '=', $journee ];
        }

        return
            $this->computeTotalPrestation($where) +
            $this->computeTotalArticle($where) +
            $this->computeTotalHotel($where);
    }

    /**
     * @param array $where
     * @return float
     */
    public function computeTotalPrestation(array $where)
    {
        $totalPrestation = 0;

        $prestations = $this->db->table('devis_prestation')->where($where)->get();

        /** @var DevisPrestation $prestation */
        foreach ($prestations as $prestation) {
            $totalPrestation += $prestation->prix_prestation * $prestation->qte_prestation;
        }

        return $totalPrestation;
    }

    /**
     * @param array $where
     * @return float
     */
    public function computeTotalArticle(array $where)
    {
        $totalArticle = 0;

        $articles = $this->db->table('devis_article')->where($where)->get();

        /** @var DevisArticle $article */
        foreach ($articles as $article) {
            $totalArticle += $article->prix_article * $article->qte_article;
        }

        return $totalArticle;
    }

    /**
     * @param array $where
     * @return float
     */
    public function computeTotalHotel(array $where)
    {
        $totalHotel = 0;

        $hotels = $this->db->table('devis_hotel')->where($where)->get();

        foreach ($hotels as $hotel) {
            $totalHotel += $hotel->qte_single * $hotel->prix_single;
            $totalHotel += $hotel->qte_double * $hotel->prix_double;
            $totalHotel += $hotel->qte_triple * $hotel->prix_triple;
            $totalHotel += $hotel->qte_familial * $hotel->prix_familial;
            $totalHotel += $hotel->qte_petit_dejeuner * $hotel->prix_petit_dejeuner;
            $totalHotel += $hotel->qte_diner * $hotel->prix_diner;
            $totalHotel += $hotel->qte_lit_supp * $hotel->prix_lit_supp;
            $totalHotel += $hotel->qte_vignette * $hotel->prix_vignette;
            $totalHotel += $hotel->qte_taxe * $hotel->prix_taxe;
        }

        return $totalHotel;
    }
}
