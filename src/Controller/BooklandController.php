<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livre;
use App\Entity\Genre;
use App\Entity\Auteur;
class BooklandController extends AbstractController
{
    /**
     * @Route("/bookland", name="bookland")
     */
    public function accueil(): Response
    {
        return $this->render('accueil.html.twig'
        );
    }

    /**
     * @Route("/bookland/init", name="bookland_init")
     */
    public function init(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $scifi = new Genre;
        $scifi->setNom('Science fiction');
        $police = new Genre;
        $police->setNom('policier');
        $philo = new Genre;
        $philo->setNom('philosophie');
        $eco = new Genre;
        $eco->setNom('économie');
        $psy = new Genre;
        $psy->setNom('psychologie');


        $em->persist($scifi);
        $em->persist($police);
        $em->persist($philo);
        $em->persist($eco);
        $em->persist($psy);

        $RichardThaler = new Auteur;
        $RichardThaler->setNomPrenom('Richard Thaler');
        $RichardThaler->setSexe('M');
        $RichardThaler->setDateDeNaissance(new \DateTime('1945-12-12'));
        $RichardThaler->setNationalite('USA');

        $CassSunstein=new Auteur;
        $CassSunstein->setNomPrenom('Cass Sunstein');
        $CassSunstein->setSexe('M');
        $CassSunstein->setDateDeNaissance(new \DateTime('1943-11-23'));
        $CassSunstein->setNationalite('Allemagne');

        $FrancisGabrelot=new Auteur;
        $FrancisGabrelot->setNomPrenom('Francis Gabrelot');
        $FrancisGabrelot->setSexe('M');
        $FrancisGabrelot->setDateDeNaissance(new \DateTime('1967-01-29'));
        $FrancisGabrelot->setNationalite('France');

        $AynRand=new Auteur;
        $AynRand->setNomPrenom('Ayn Rand');
        $AynRand->setSexe('F');
        $AynRand->setDateDeNaissance(new \DateTime('1950-06-21'));
        $AynRand->setNationalite('Russie');

        $Duschmol=new Auteur;
        $Duschmol->setNomPrenom('Duschmol');
        $Duschmol->setSexe('M');
        $Duschmol->setDateDeNaissance(new \DateTime('2001-12-23'));
        $Duschmol->setNationalite('Groland');

        $NancyGrave=new Auteur;
        $NancyGrave->setNomPrenom('Nancy Grave');
        $NancyGrave->setSexe('F');
        $NancyGrave->setDateDeNaissance(new \DateTime('1952-10-24'));
        $NancyGrave->setNationalite('USA');

        $JamesEnckling=new Auteur;
        $JamesEnckling->setNomPrenom('James Enckling');
        $JamesEnckling->setSexe('M');
        $JamesEnckling->setDateDeNaissance(new \DateTime('1970-07-03'));
        $JamesEnckling->setNationalite('USA');

        $JeanDupont=new Auteur;
        $JeanDupont->setNomPrenom('Jean Dupont');
        $JeanDupont->setSexe('M');
        $JeanDupont->setDateDeNaissance(new \DateTime('1970-07-03'));
        $JeanDupont->setNationalite('France');

        $em->persist($RichardThaler);
        $em->persist($CassSunstein);
        $em->persist($FrancisGabrelot);
        $em->persist($AynRand);
        $em->persist($Duschmol);
        $em->persist($NancyGrave);
        $em->persist($JamesEnckling);
        $em->persist($JeanDupont);




        $Symfonystique = new Livre;
        $Symfonystique ->setTitre('Symfonystique');
        $Symfonystique ->setIsbn('978-2-07-036822-8');
        $Symfonystique ->setNbpages(117);
        $Symfonystique->setDateDeParution(new \DateTime('2008-01-20'));
        $Symfonystique ->setNote(8);
        $Symfonystique ->addLivreGenre($police);
        $Symfonystique ->addLivreGenre($philo);
        $Symfonystique ->addAuteurLivre($FrancisGabrelot);
        $Symfonystique ->addAuteurLivre($AynRand);
        $Symfonystique ->addAuteurLivre($NancyGrave);
        $em->persist($Symfonystique);

        $greve = new Livre;
        $greve ->setTitre('La grève');
        $greve ->setIsbn('978-2-251-44417-8');
        $greve ->setNbpages(1245);
        $greve->setDateDeParution(new \DateTime('1961-06-12'));
        $greve ->setNote(19);
        $greve ->addLivreGenre($philo);
        $greve ->addAuteurLivre($AynRand);
        $greve ->addAuteurLivre($JamesEnckling);
        $em->persist($greve);

        
        $Symfonyland = new Livre;
        $Symfonyland ->setTitre('Symfonyland');
        $Symfonyland ->setIsbn(' 978-2-212-55652-0');
        $Symfonyland ->setNbpages(131);
        $Symfonyland->setDateDeParution(new \DateTime('1980-09-17'));
        $Symfonyland ->setNote(15);
        $Symfonyland ->addLivreGenre($scifi);
        $Symfonyland ->addAuteurLivre($JeanDupont);
        $Symfonyland ->addAuteurLivre($JamesEnckling);
        $Symfonyland ->addAuteurLivre($AynRand);
        $em->persist($Symfonyland);

        $Négociation = new Livre;
        $Négociation ->setTitre('Négociation Complexe');
        $Négociation ->setIsbn(' 978-2-0807-1057-4');
        $Négociation ->setNbpages(234);
        $Négociation->setDateDeParution(new \DateTime('1992-09-25'));
        $Négociation ->setNote(16);
        $Négociation ->addLivreGenre($psy);
        $Négociation ->addAuteurLivre($RichardThaler);
        $Négociation ->addAuteurLivre($CassSunstein);
        $em->persist($Négociation);

     

        $maVie=new Livre;
        $maVie->setTitre('Ma vie');
        $maVie->setISBN('978-0-300-12223-7');
        $maVie->setNbpages(5);
        $maVie->setNote(3);
        $maVie->addLivreGenre($police);
        $maVie->addAuteurLivre($JeanDupont);
        $maVie->setDateDeParution(new \DateTime('2021-11-08'));
        $em->persist($maVie);

        $MaVieSuite=new Livre;
        $MaVieSuite->setTitre('Ma vie : suite');
        $MaVieSuite->setISBN('978-0-141-18776-1');
        $MaVieSuite->setNbpages(5);
        $MaVieSuite->setNote(1);
        $MaVieSuite->addLivreGenre($police);
        $MaVieSuite->addAuteurLivre($JeanDupont);
        $MaVieSuite->setDateDeParution(new \DateTime('2021-11-09'));
        $em->persist($MaVieSuite);


        $Lemonde=new Livre;
        $Lemonde->setTitre('Le monde comme volonté et comme représentation');
        $Lemonde->setISBN('978-0-141-18786-0');
        $Lemonde->setNbpages(1987);
        $Lemonde->setNote(19);
        $Lemonde->addLivreGenre($philo);
        $Lemonde->addAuteurLivre($NancyGrave);
        $Lemonde->addAuteurLivre($FrancisGabrelot);
        $Lemonde->setDateDeParution(new \DateTime('1821-11-09'));
        $em->persist($Lemonde);


        $em->flush();
        return $this->render('bookland/index.html.twig'
        );
    }
}
