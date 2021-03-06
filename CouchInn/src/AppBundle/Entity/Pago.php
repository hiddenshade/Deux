<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 22/05/16
 * Time: 20:51
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pago")
 */
class Pago
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $monto;
    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min=6,max="6")
     * @Assert\Type(type="digit",
     *  message="Ingrese un valor numerico."
     * )
     */
    private $tarjeta;
    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min="3",max="3")
     * @Assert\Type(type="digit",
     *  message="Ingrese un valor numerico."
     * )
     */
    private $codSeguridad;
    /**
     * @ORM\Column(type="date")
     */
    private $vencimiento;
    /**
     * @ORM\Column(type="date")
     */
    private $vencimientoTarjeta;
    /**
     * @ORM\Column(type="string")
     */
    private $tipoTarjeta;
    /**
     * @ORM\Column(type="string")
     */
    private $nombreCompleto;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="pagos")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

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
     * Set monto
     *
     * @param integer $monto
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getTarjeta()
    {
        return $this->tarjeta;
    }

    /**
     * Set monto
     *
     * @param integer $monto
     */
    public function setTarjeta($tarjeta)
    {
        $this->tarjeta = $tarjeta;
    }
    /**
     * Get monto
     *
     * @return integer 
     */
    public function getMonto()
    {
        return $this->monto;
    }
    /**
     * estaVencido
     *
     * @return boolean
     */
    public function estaVencido()
    {
        if($this->vencimiento<= new \DateTime('today')){
            return true;
        }
        else return false;
    }
    /**
     * Set vencimiento
     *
     * @param \DateTime $vencimiento
     */
    public function setVencimiento($vencimiento)
    {
        $this->vencimiento = $vencimiento;
    }

    /**
     * Get vencimiento
     *
     * @return \DateTime
     */
    public function getVencimiento()
    {
        return $this->vencimiento;
    }
    /**
     * Set vencimientoTarjeta
     *
     * @param \DateTime $vencimientoTarjeta
     */
    public function setVencimientoTarjeta($vencimientoTarjeta)
    {
        $this->vencimientoTarjeta = $vencimientoTarjeta;
    }

    /**
     * Get vencimientoTarjeta
     *
     * @return \DateTime
     */
    public function getVencimientoTarjeta()
    {
        return $this->vencimientoTarjeta;
    }

    /**
     * Set codSeguridad
     *
     * @param integer $codSeguridad
     */
    public function setCodSeguridad($codSeguridad)
    {
        $this->codSeguridad = $codSeguridad;
    }

    /**
     * Get codSeguridad
     *
     * @return integer
     */
    public function getCodSeguridad()
    {
        return $this->codSeguridad;
    }
    /**
     * Set tipoTarjeta
     *
     * @param string $tipoTarjeta
     */
    public function setTipoTarjeta($tipoTarjeta)
    {
        $this->tipoTarjeta = $tipoTarjeta;
    }

    /**
     * Get tipoTarjeta
     *
     * @return string
     */
    public function getTipoTarjeta()
    {
        return $this->tipoTarjeta;
    }
    /**
     * Set nombreCompleto
     *
     * @param string $tipoTarjeta
     */
    public function setNombreCompleto($nombreCompleto)
    {
        $this->nombreCompleto = $nombreCompleto;
    }

    /**
     * Get nombreCompleto
     *
     * @return string
     */
    public function getNombreCompleto()
    {
        return $this->nombreCompleto;
    }
    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set usuario
     *
     * @param integer
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
}
