<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * A user.
 * @ApiResource
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface {
	
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $phone;
	
		/**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;
		
		/**
     * @ORM\OneToMany(targetEntity="App\Entity\Lists", mappedBy="userid")
		 * @ApiSubresource
     */
    private $lists;
		
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $confirmed;

	
    public function __construct() {
			$this->roles[] = 'ROLE_USER';
			$this->lists = new ArrayCollection();
			$this->confirmed = mt_rand(1000000000, 10000000000); }

	
    public function getId(): int {
        return $this->id; }

	
    public function getPhone(): string {
        return $this->phone; }

    public function setPhone(string $phone): self {
        $this->phone = $phone;
        return $this; }
	
	
		public function getEmail(): string {
        return $this->email; }

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this; }

	
    public function getRoles(): array {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles); }

    public function setRoles(array $roles): self {
        $this->roles = $roles;
        return $this; }

	
    public function getPassword(): string {
        return $this->password; }

    public function setPassword(string $password): self {
        $this->password = $password;
        return $this; }


    public function getFirstName(): string {
        return $this->firstName; }

    public function setFirstName(string $firstName): self {
        $this->firstName = $firstName;
        return $this; }
	

    public function getLastName(): string {
        return $this->lastName; }

    public function setLastName(string $lastName): self {
        $this->lastName = $lastName;
        return $this; }

	
    public function getCountry(): string {
        return $this->country; }

    public function setCountry(string $country): self {
        $this->country = $country;
        return $this; }

	
    public function getGender(): string {
        return $this->gender; }

    public function setGender(string $gender): self {
        $this->gender = $gender;
        return $this; }
		
		
		
    public function getLists(): Collection {
        return $this->lists; }

    public function addList(Lists $list): self {
        if (!$this->lists->contains($list)) {
            $this->lists[] = $list;
            $list->setUserid($this); }
        return $this; }

    public function removeList(Lists $list): self {
        if ($this->lists->contains($list)) {
            $this->lists->removeElement($list);
            // set the owning side to null (unless already changed)
            if ($list->getUserid() === $this) {
                $list->setUserid(null); } }
        return $this; }

	
    public function getConfirmed(): string {
        return $this->confirmed; }

    public function setConfirmed(string $confirmed): self {
        $this->confirmed = $confirmed;
        return $this; }
	
	
		public function getSalt() {}

    public function eraseCredentials() {}
	
		public function getUsername() {
			return $this->email;
		}
}
