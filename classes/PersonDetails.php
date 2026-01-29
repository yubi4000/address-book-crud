<?php
class PersonDetails
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // fetch details by person_id
    public function getByPersonId(int $personId): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM person_details WHERE person_id = :person_id"
        );
        $stmt->execute(['person_id' => $personId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(int $personId, array $data): void
    {
        $stmt = $this->db->prepare("
            UPDATE person_details 
            SET street = :street,
                number = :number,
                city = :city,
                zip_code = :zip_code,
                country = :country,
                email = :email,
                phone_1 = :phone_1,
                phone_2 = :phone_2
            WHERE person_id = :person_id
        ");
        
        $stmt->execute([
            'street'     => $data['street'] ?? '',
            'number'     => $data['number'] ?? '',
            'city'       => $data['city'] ?? '',
            'zip_code'   => $data['zip_code'] ?? '',
            'country'    => $data['country'] ?? '',
            'email'      => $data['email'] ?? '',
            'phone_1'    => $data['phone_1'] ?? '',
            'phone_2'    => $data['phone_2'] ?? '',
            'person_id'  => $personId
        ]);
    }
}