<?php

namespace Rayku\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Rayku\ApiBundle\Entity\Course;
use Rayku\ApiBundle\Form\CourseType;
/**
 * RestCourse controller.
 */
class CourseController extends Controller
{
	/**
	 * @Secure(roles="ROLE_USER")
	 * @ApiDoc(
	 *   description="Returns all courses",
	 *   resource=true,
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   }
	 * )
	 * @View(serializerGroups={"course"})
	 */
	public function getCoursesAction()
	{
		$em = $this->getDoctrine()->getManager();
		$courses = $em->getRepository('RaykuApiBundle:Course')->findAll();
	
		return $courses;
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful"
     *   },
	 *   description="Get a course record",
	 *   output="Rayku\ApiBundle\Entity\Course"
	 * )
	 * @View(serializerGroups={"course.details", "session"})
	 */
	public function getCourseAction($course)
	{
		$em = $this->getDoctrine()->getRepository('RaykuApiBundle:Course');
		if(is_numeric($course)){
			$course = $em->find($course);
		}else{
			$course = $em->findOneBySlug($course);
		}
		
		if(!$course){
			throw $this->createNotFoundException('The course was not found');
		}
		
		return $course;
	}
}

