namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;

class AdminController extends AbstractController
{
    #[Route('/admin/', name: 'admin')]
    public function index(UserRepository $userRepository): Response
    {
        // Fetch all users from the UserRepository
        $users = $userRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
        ]);
    }

    #[Route('/admin/user', name: 'admin_user')]
    public function users(): Response
    {
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
