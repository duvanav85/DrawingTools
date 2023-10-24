<?php
    namespace App\Controller;
 
    //use App\Entity\Drawing;
    //use App\Repository\DrawingRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    
    class DrawingController extends AbstractController
    {
        public function index()
        {
            return $this->render('Drawing/index.html.twig');
        }

    }

?>