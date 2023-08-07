<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Logout\LogoutUrlGenerator;
use App\Entity\User;
use \Firebase\JWT\JWT;

class LoginController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('security/register.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/register/process', name: 'register_post', methods: ['POST'])]
    public function registerPost(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {


        $data = $request->request->all();

        $user = new User();
        $user->setFirstname($data['first_name']);
        $user->setLastname($data['last_name']);
        $user->setEmail($data['email']);
        $user->setAge((int)$data['age']);
        $user->setWeight((int)$data['weight']);
        $user->setHeight((int)$data['height']);
        $user->setPhoneNumber($data['phone_number']);
        $user->setRoles(['ROLE_USER']);

        // Conversion de la date de naissance de string en datetime
        $birthdate = $data['birthdate'] ?? null;
        if ($birthdate) {
            $birthdate = \DateTime::createFromFormat('d/m/Y', $birthdate);
            $user->setBirthdate($birthdate);
        }

        // Hacher le mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Persiste l'utilisateur dans la base de données
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }


    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('security/login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/login/process', name: 'login_post', methods: ['POST'])]
    public function loginPost(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager,
        EntityManagerInterface $entityManager
    ): Response {


        $data = $request->request->all();

        // Check if the required fields are provided
        if (!isset($data['email']) || !isset($data['password'])) {
            throw new AuthenticationException('Email and password are required.');
        }

        // Find the user by email
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $data['email']]);

        // Check if the user exists
        if (!$user) {
            throw new AuthenticationException('User not found.');
        }

        // Verify the password
        if (!$passwordHasher->isPasswordValid($user, $data['password'])) {
            throw new AuthenticationException('Invalid credentials.');
        }

        // Si login réussi, générer le JWT token
        $token = $jwtManager->create($user);

        // Créer un cookie avec le token JWT
        $cookie = Cookie::create('JWT', $token, strtotime('+1 hour'), '/', null, false, true, false, 'lax');

        // Rediriger vers la page souhaitée après la connexion réussie
        $response = $this->redirectToRoute('home');

        $request->attributes->set('jwt_token', $token);
        $secretKey = 
        'MIIFHDBOBgkqhkiG9w0BBQ0wQTApBgkqhkiG9w0BBQwwHAQISv2yvOzO+JYCAggA
        MAwGCCqGSIb3DQIJBQAwFAYIKoZIhvcNAwcECMlwAlR+MIcuBIIEyGmN+KSWepZL
        exRtj3PjI6K3SNNViZgnbYPfBJCIOkkSyT7dzbEKtMkHqWd6gJ5BbHtNlY8QZ6sY
        DBFbwMaU9vHE6o1qoUUc3tzkvc5ZMHnGEjAyuSGYv0kGnkmL7LNcFp1u3/+/UkNv
        g8AKB9HrTXfH/yGCgXjSxWSKdhx5bJaOsMmJCE6sZNsGnYlrstUcRaPSzy6KWJf0
        gWHey5sdNCjiwcpkadSsV5W4A0Ththp2aaoBT2aFnqwOx03rbkqRN872A0FnY/Ms
        Lpvi9JYmIJiyDWv5fL7Cj1iZoPlGxah3qMD2IP014HXnNrrpI6VPyiUBYq9DZdNm
        70hAnCOWt9t9wl7ER6W+hpxzORsBuPhr/kMsGD8kCzJPN6PkJyBu+Aqi+Nbltme8
        q1B8ZclS5dcJ0wSb54eI37d1B7VH8NgShcv2MvoHZuuopBkJK5vw22AVNFbtPbdt
        uQcuyWzM3JlKK7bdNNxxyc+j9qq7/jNFWWY2whshYr9Z9h2fg2xE+rR6w1WUNoS+
        242EuAvh/WPHTF9NkXrr/Q3w4IqItN39f2zBfmr/9b3BTieI6YDAlUl126AL9bWB
        nZ7LzJqUlwUXcztDdKux1HFErhmn6bo/ZdLN3NDIq7gJohSmKs/r5aaltYUzftgJ
        wKIeJhuyVwzcwpL54/ZZhP57ntubzOQMGtQrFhWujNPeqMXM43vxhe+Ww32Jh9lT
        Wo8erIp2eOdnKOIJy4sjFuWxdnAHZIHlfsJuz4gJ+TXHr97OHhUHenBRHsZAlzRe
        UmpgydpSup4YWcVId9q54M9DE7YhxEgNsl4tasskevWsNHeDJRmNqeuGcbSMW7iy
        emOZT0TvnpVHqeuewZpZR9iWXLo5tgi/l80Wx9c2fzGJkU1BZEd3Q1Y1IduqY21E
        Rsu4w4lod7jtZglA5mA7vzqulqaNqR0w54JUQ2mgimda464IzsSeibuc6S9/ZIs7
        KJDRB29b3z8im0mf0wcGnxRgcX9c7t1Lk7fmG/XplbIa5IL4meF8c1zUylmb0G/l
        fknhnsnDabSDgz9uN+wvVwBdwr38XIq0OiBswSQoFD5D2KXNoTTrAwrXTSivz2oK
        O1I+YDTydq2ChgLDsyDO30V7mjQSNDEliyR5NZcgYGlvePnM1yWAh3/9luTqwKgM
        +Vy1fk5kM/ypVg0EI3kzE12C9QUQeG6T7uPgB1pm6K21SaDqn01zP1FcdVPY/Rkd
        kt2lka9Mqu/l/fBh6p5OKnAs4WfY+HQBVaxJ0AAtWKD4DbZrpZ84V51BfWcqz9tf
        3dH28Ynblgh65iQIww7g7uubCArdVhYlF9aDp+YiZpUchfMGWknhpWHv1sklMaOf
        98U/ZDfG5oGupaDYyOeF60CKPFhGNE1WGG6zxsDRrM4xHs1UhxyFv07LizpfdhDS
        vLTZGQl/zE3XRlnCsl7c31Y4E9CEa4B3fgT455ua06xZPr6bod/7qjtgz4Wd/ve6
        3kvrs/jEm8EL6Ylm8Os9ZgkDZ4xBKf7GCaDEPrFst636ORS/C2kuLZvkmFOC6LSz
        JeJgwK+Sx/B7z+PQ3TdGYUdSyMTLx06CF3hGLb06KYuLRnCloIhq0whgRcMe8c1S
        L2NcQnWekwZ+1wgq2EyDvg==';
        dd($secretKey);

        $    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        print_r($decoded);

        // Ajouter le cookie à la réponse
        $response->headers->setCookie($cookie);


        

        return $response;
    }

    #[Route('/logout', name: 'logout')]
public function logout(LogoutUrlGenerator $logoutUrlGenerator): RedirectResponse
{
    // This method can be empty, as it's handled by Symfony's security system
    return new RedirectResponse($logoutUrlGenerator->getLogoutUrl());
}
}
