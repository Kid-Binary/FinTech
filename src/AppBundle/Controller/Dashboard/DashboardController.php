<?php
// AppBundle/Controller/Dashboard/DashboardController.php
namespace AppBundle\Controller\Dashboard;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JMS\DiExtraBundle\Annotation as DI;

class DashboardController extends Controller
{
    /** @DI\Inject("security.authorization_checker") */
    private $_authorizationChecker;

    /**
     * @Method({"GET"})
     * @Route(
     *      "/",
     *      name="employee_dashboard",
     *      host="{domain_dashboard}",
     *      defaults={"_locale" = "%locale_dashboard%", "domain_dashboard" = "%domain_dashboard%"},
     *      requirements={"_locale" = "%locale_dashboard%", "domain_dashboard" = "%domain_dashboard%"}
     * )
     */
    public function indexAction()
    {
        if( $this->_authorizationChecker->isGranted('ROLE_ADMIN') ) {
            return $this->redirectToRoute('employee_read');
        } else {
            return $this->redirectToRoute('operator_read');
        }
    }
}
