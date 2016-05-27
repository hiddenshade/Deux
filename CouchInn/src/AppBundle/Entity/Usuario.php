<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 22/05/16
 * Time: 20:50
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 */
class Usuario extends BaseUser implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=30)
     */
    private $pregunta;
    /**
     * @ORM\Column(type="string", length=15)
     */
    private $respuesta;
    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     */
    private $fechaDeNacimiento;
    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(18)
     * @Assert\LessThan(100)
     */
    private $edad;
    /**
     * @ORM\Column(type="string")
     * @Assert\Country()
     */
    private $pais;
    /**
     * @ORM\Column(type="string")
     */
    private $provincia;
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $localidad;
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $calle;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Publicacion", mappedBy="usuario")
     */
    private $publicaciones;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CalificacionUsuario", mappedBy="paraUsuario")
     */
    private $calificaciones;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CalificacionUsuario", mappedBy="deUsuario")
     */
    private $misCalificacionesAUsuarios;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CalificacionPublicacion", mappedBy="deUsuario")
     */
    private $misCalificacionesAPublicaciones;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comentario", mappedBy="deUsuario")
     */
    private $misComentarios;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pago", mappedBy="usuario")
     */
    private $pagos;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->publicaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->calificaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->misCalificacionesAUsuarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->misCalificacionesAPublicaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->misComentarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pagos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }


    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set pregunta
     *
     * @param string $pregunta
     * @return Usuario
     */
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return string 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set respuesta
     *
     * @param string $respuesta
     * @return Usuario
     */
    public function setRespuesta($respuesta)
    {
        $this->respuesta = $respuesta;

        return $this;
    }

    /**
     * Get respuesta
     *
     * @return string 
     */
    public function getRespuesta()
    {
        return $this->respuesta;
    }

    /**
     * Set rol
     *
     * @param integer $rol
     * @return Usuario
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return integer 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set fechaDeNacimiento
     *
     * @param \DateTime $fechaDeNacimiento
     * @return Usuario
     */
    public function setFechaDeNacimiento($fechaDeNacimiento)
    {
        $this->fechaDeNacimiento = $fechaDeNacimiento;

        return $this;
    }

    /**
     * Get fechaDeNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaDeNacimiento()
    {
        return $this->fechaDeNacimiento;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     * @return Usuario
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer 
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return Usuario
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return Usuario
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     * @return Usuario
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set calle
     *
     * @param string $calle
     * @return Usuario
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Usuario
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add publicaciones
     *
     * @param \AppBundle\Entity\CalificacionPublicacion $publicaciones
     * @return Usuario
     */
    public function addPublicacione(\AppBundle\Entity\CalificacionPublicacion $publicaciones)
    {
        $this->publicaciones[] = $publicaciones;

        return $this;
    }

    /**
     * Remove publicaciones
     *
     * @param \AppBundle\Entity\CalificacionPublicacion $publicaciones
     */
    public function removePublicacione(\AppBundle\Entity\CalificacionPublicacion $publicaciones)
    {
        $this->publicaciones->removeElement($publicaciones);
    }

    /**
     * Get publicaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPublicaciones()
    {
        return $this->publicaciones;
    }

    /**
     * Add calificaciones
     *
     * @param \AppBundle\Entity\CalificacionUsuario $calificaciones
     * @return Usuario
     */
    public function addCalificacione(\AppBundle\Entity\CalificacionUsuario $calificaciones)
    {
        $this->calificaciones[] = $calificaciones;

        return $this;
    }

    /**
     * Remove calificaciones
     *
     * @param \AppBundle\Entity\CalificacionUsuario $calificaciones
     */
    public function removeCalificacione(\AppBundle\Entity\CalificacionUsuario $calificaciones)
    {
        $this->calificaciones->removeElement($calificaciones);
    }

    /**
     * Get calificaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCalificaciones()
    {
        return $this->calificaciones;
    }

    /**
     * Add misCalificacionesAUsuarios
     *
     * @param \AppBundle\Entity\CalificacionUsuario $misCalificacionesAUsuarios
     * @return Usuario
     */
    public function addMisCalificacionesAUsuario(\AppBundle\Entity\CalificacionUsuario $misCalificacionesAUsuarios)
    {
        $this->misCalificacionesAUsuarios[] = $misCalificacionesAUsuarios;

        return $this;
    }

    /**
     * Remove misCalificacionesAUsuarios
     *
     * @param \AppBundle\Entity\CalificacionUsuario $misCalificacionesAUsuarios
     */
    public function removeMisCalificacionesAUsuario(\AppBundle\Entity\CalificacionUsuario $misCalificacionesAUsuarios)
    {
        $this->misCalificacionesAUsuarios->removeElement($misCalificacionesAUsuarios);
    }

    /**
     * Get misCalificacionesAUsuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMisCalificacionesAUsuarios()
    {
        return $this->misCalificacionesAUsuarios;
    }

    /**
     * Add misCalificacionesAPublicaciones
     *
     * @param \AppBundle\Entity\CalificacionPublicacion $misCalificacionesAPublicaciones
     * @return Usuario
     */
    public function addMisCalificacionesAPublicacione(\AppBundle\Entity\CalificacionPublicacion $misCalificacionesAPublicaciones)
    {
        $this->misCalificacionesAPublicaciones[] = $misCalificacionesAPublicaciones;

        return $this;
    }

    /**
     * Remove misCalificacionesAPublicaciones
     *
     * @param \AppBundle\Entity\CalificacionPublicacion $misCalificacionesAPublicaciones
     */
    public function removeMisCalificacionesAPublicacione(\AppBundle\Entity\CalificacionPublicacion $misCalificacionesAPublicaciones)
    {
        $this->misCalificacionesAPublicaciones->removeElement($misCalificacionesAPublicaciones);
    }

    /**
     * Get misCalificacionesAPublicaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMisCalificacionesAPublicaciones()
    {
        return $this->misCalificacionesAPublicaciones;
    }

    /**
     * Add misComentarios
     *
     * @param \AppBundle\Entity\Comentario $misComentarios
     * @return Usuario
     */
    public function addMisComentario(\AppBundle\Entity\Comentario $misComentarios)
    {
        $this->misComentarios[] = $misComentarios;

        return $this;
    }

    /**
     * Remove misComentarios
     *
     * @param \AppBundle\Entity\Comentario $misComentarios
     */
    public function removeMisComentario(\AppBundle\Entity\Comentario $misComentarios)
    {
        $this->misComentarios->removeElement($misComentarios);
    }

    /**
     * Get misComentarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMisComentarios()
    {
        return $this->misComentarios;
    }

    /**
     * Add pagos
     *
     * @param \AppBundle\Entity\Pago $pagos
     * @return Usuario
     */
    public function addPago(\AppBundle\Entity\Pago $pagos)
    {
        $this->pagos[] = $pagos;

        return $this;
    }

    /**
     * Remove pagos
     *
     * @param \AppBundle\Entity\Pago $pagos
     */
    public function removePago(\AppBundle\Entity\Pago $pagos)
    {
        $this->pagos->removeElement($pagos);
    }

    /**
     * Get pagos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPagos()
    {
        return $this->pagos;
    }
}
