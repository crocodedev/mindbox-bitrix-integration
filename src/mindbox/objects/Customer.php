<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Object;

use DateTime;
use InvalidArgumentException;

class Customer
{
    use ObjectStandart;

    private int $websiteID;
    private ?DateTime $birthDate = null;
    private ?string $sex = null;
    private ?string $timeZone = null;
    private ?string $lastName = null;
    private ?string $firstName = null;
    private ?string $middleName = null;
    private ?string $fullName = null;
    private ?string $email = null;
    private ?string $mobilePhone = null;
    private ?DateTime $executionDateTimeUtc = null;

    public function __construct(array $params) {
        $this->name = 'customer';

        foreach ($params as $keyParam => $valueParam) {
            $setKey = "set$keyParam";

            $this->$setKey($valueParam);
        }
    }

    /**
     * @param int $websiteID
     * @return Customer
     */
    public function setWebsiteID(int $websiteID): Customer
    {
        $this->websiteID = $websiteID;
        return $this;
    }
    /**
     * @param DateTime|null $birthDate
     * @return Customer
     */
    public function setBirthDate(?DateTime $birthDate): Customer
    {
        $this->birthDate = $birthDate;
        return $this;
    }
    /**
     * @param string|null $sex
     * @return Customer
     */
    public function setSex(?string $sex): Customer
    {
        if ($sex === 'm' || $sex === 'f' || $sex === null) {
            $this->sex = $sex;
            return $this;
        } else {
            throw new InvalidArgumentException("Недопустимое значение пола. Используйте «m» или «f».");
        }
    }
    /**
     * @param string|null $timeZone
     * @return Customer
     */
    public function setTimeZone(?string $timeZone): Customer
    {
        $this->timeZone = $timeZone;
        return $this;
    }
    /**
     * @param string|null $lastName
     * @return Customer
     */
    public function setLastName(?string $lastName): Customer
    {
        $this->lastName = $lastName;
        return $this;
    }
    /**
     * @param string|null $firstName
     * @return Customer
     */
    public function setFirstName(?string $firstName): Customer
    {
        $this->firstName = $firstName;
        return $this;
    }
    /**
     * @param string|null $middleName
     * @return Customer
     */
    public function setMiddleName(?string $middleName): Customer
    {
        $this->middleName = $middleName;
        return $this;
    }
    /**
     * @param string|null $fullName
     * @return Customer
     */
    public function setFullName(?string $fullName): Customer
    {
        $this->fullName = $fullName;
        return $this;
    }
    /**
     * @param string|null $email
     * @return Customer
     */
    public function setEmail(?string $email): Customer
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string|null $mobilePhone
     * @return Customer
     */
    public function setMobilePhone(?string $mobilePhone): Customer
    {
        $mobilePhone = str_replace(['(', ')', ' ', '-', '+'], '', $mobilePhone);

        $this->mobilePhone = $mobilePhone;
        return $this;
    }
    /**
     * @param DateTime|null $executionDateTimeUtc
     * @return Customer
     */
    public function setExecutionDateTimeUtc(?DateTime $executionDateTimeUtc): Customer
    {
        $this->executionDateTimeUtc = $executionDateTimeUtc;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getIds(): ?array
    {
        return (!empty($this->websiteID) && $this->websiteID > 0) ? ['websiteID' => $this->websiteID] : null;
    }

    /**
     * @return string|null
     */
    public function getBirthDate(): ?string
    {
        $dateStr = null;
        if (!empty($this->birthDate))
            $dateStr = $this->birthDate->format('Y-m-d');

        return $dateStr;
    }
    /**
     * @return string|null
     */
    public function getSex(): ?string
    {
        return $this->sex ?? null;
    }
    /**
     * @return string|null
     */
    public function getTimeZone(): ?string
    {
        return $this->timeZone ?? null;
    }
    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        if (!empty($this->fullName))
            $fullName = $this->fullName;
        else {
            $fullNameArr = [];
            if (!empty($this->lastName)) {
                $fullNameArr[] = $this->lastName;
            }
            if (!empty($this->firstName)) {
                $fullNameArr[] = $this->firstName;
            }
            if (!empty($this->middleName)) {
                $fullNameArr[] = $this->middleName;
            }

            $fullName = (count($fullNameArr) > 0) ? implode(' ', $fullNameArr) : null;
        }

        return $fullName;
    }
    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email ?? null;
    }

    /**
     * @return string|null
     */
    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone ?? null;
    }
}
