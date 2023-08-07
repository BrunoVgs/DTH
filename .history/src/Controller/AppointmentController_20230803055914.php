// App/Controller/AppointmentController.php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentController extends AbstractController
{
    #[Route('/appointment', name: 'appointment')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            // Récupérer les informations du formulaire
            $centerName = $request->request->get('center_name');
            $centerAddress = $request->request->get('center_address');
            $centerCity = $request->request->get('center_city');
            $centerPostalCode = $request->request->get('center_postal_code');
            
            // Rediriger vers le formulaire de prise de rendez-vous avec les informations du centre
            return $this->redirectToRoute('appointment_form', [
                'centerName' => $centerName,
                'centerAddress' => $centerAddress,
                'centerCity' => $centerCity,
                'centerPostalCode' => $centerPostalCode,
            ]);
        }

        // Récupérer la liste des centres depuis la base de données (exemple: $centers = $entityManager->getRepository(Center::class)->findAll();)
        $centers = []; // Remplacez ceci par le code pour récupérer les centres depuis la base de données

        return $this->render('appointment/index.html.twig', [
            'centers' => $centers,
        ]);
    }

    #[Route('/appointment/form', name: 'appointment_form')]
    public function appointmentForm(Request $request): Response
    {
        // Récupérer les informations du centre depuis les paramètres de la route
        $centerName = $request->query->get('centerName');
        $centerAddress = $request->query->get('centerAddress');
        $centerCity = $request->query->get('centerCity');
        $centerPostalCode = $request->query->get('centerPostalCode');
        // ...

        // Code pour afficher le formulaire de prise de rendez-vous avec les informations du centre
        return $this->render('appointment/form.html.twig', [
            'centerName' => $centerName,
            'centerAddress' => $centerAddress,
            'centerCity' => $centerCity,
            'centerPostalCode' => $centerPostalCode,
        ]);
    }
}
