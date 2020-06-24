<?php
// src/Security/TokenAuthenticator.php
namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class GoogleAuthenticator extends AbstractGuardAuthenticator
{
		private $em;

		public function __construct(EntityManagerInterface $em)
		{
				$this->em = $em;
		}
		/**
		 * A chaque fois qu'on appelle la route 'google_login' avec la méthode POST
		 * on essai de s'authentifier avec Google.
		 * Si renvoie faux alors le reste du code de ce fichier ne sera pas pris en compte
		 */
    public function supports(Request $request)
    {
				return 'google_login' === $request->attributes->get('_route')
						&& $request->isMethod('POST');
    }

		/**
		 * Récupération du token Google dans les paramètres du POST
		 */
    public function getCredentials(Request $request)
    {
				return [
						'id_token' => $request->request->get('id_token'),
				];
    }
		/**
		 * @param $credentials Paramétre récupéré depuis self::getCredentials()
		 */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
				$idToken = $credentials['id_token'];

				// Si il n'y a pas le param id_token dans le POST alors on quitte la méthode
				if (null === $idToken) {
						return;
				}

				$client = new \Google_Client([
						'client_id' => $_ENV['APP_GOOGLE_ID']
				]);

				// Appel à l'API Google pour vérifier si le token est valide
				/** @var $payload Informations de l'utilisateur récupérer dans l'API Google */
				$payload = $client->verifyIdToken($idToken);

				// On essaie de récupérer en base de données l'utilisateur avec son ID Google
				/** @var $user User */
				$user = $this->em->getRepository(User::class)->findOneBy([
					'google' => $payload['sub']
				]);

				// Si on a pas récupéré l'utilisateur en base de données
				if (!$user) {

					// On essaie de récupérer l'utilisateur avec son mail Google en base de données qui se serait inscrit depuis une autre méthode que Google
					// Par exemple avec Facebook
					$user = $this->em->getRepository(User::class)->findOneBy([
						'email' => $payload['email']
					]);

					// Si le mail existe on modifie en base de donnée l'utilisateur pour lui attribuer son ID google
					if (!$user) {
							$user = new User;
							$user->setEmail($payload['email']);
							$user->setFirstName($payload['given_name']);
							$user->setLastName($payload['family_name']);
					}

					$user->setGoogle($payload['sub']);

					// On enregistre le tout en base
					$this->em->persist($user);
					$this->em->flush();
				}

				// if a User object, checkCredentials() is called
				return $user;
		}

    public function checkCredentials($credentials, UserInterface $user)
    {
				// check credentials - e.g. make sure the password is valid
				// no credential check is needed in this case

				// return true to cause authentication success
				return true;
		}

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
				// En cas d'erreur on renvoi une exception qui va afficher un message "required auth"
				throw new AuthenticationException();
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
				// on success, let the request continue
				return null;
    }

		/**
		 * Called when authentication is needed, but it's not sent
		 */
    public function start(Request $request, AuthenticationException $authException = null)
    {
				$data = [
						// you might translate this message
						'message' => 'Authentication Required'
				];

				return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
		}

		public function supportsRememberMe()
		{
				return false;
		}
}
?>
