<?php

namespace App\Entity\Forms;

use Symfony\Component\Validator\Constraints as Assert;

class SignupForm
{
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6)]
    private string $password;

    #[Assert\NotBlank]
    #[Assert\Regex(pattern : "/^[0-9]*$/", message: "number only")]
    #[Assert\Length(min: 10, max: 10)]
    private string $phone;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = trim(strip_tags($email));
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = trim(strip_tags($password));
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = trim(strip_tags($phone));
    }
}
