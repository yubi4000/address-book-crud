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
        $data = $this->normalizeInput($data);

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

    public function create(int $personId, array $data = [])
    {
        $data = $this->normalizeInput($data);

        $stmt = $this->db->prepare("
            INSERT INTO person_details
            (person_id, street, number, city, zip_code, country, email, phone_1, phone_2)
            VALUES
            (:person_id, :street, :number, :city, :zip_code, :country, :email, :phone_1, :phone_2)
        ");

        $stmt->execute([
            'person_id' => $personId,
            'street'    => $data['street'] ?? '',
            'number'    => $data['number'] ?? '',
            'city'      => $data['city'] ?? '',
            'zip_code'  => $data['zip_code'] ?? '',
            'country'   => $data['country'] ?? '',
            'email'     => $data['email'] ?? '',
            'phone_1'   => $data['phone_1'] ?? '',
            'phone_2'   => $data['phone_2'] ?? ''
        ]);
    }

    /**
     * Normalize details input for consistent storage.
     *
     * @param array $data Raw details input.
     * @return array Normalized details input.
     */
    public function normalizeInput(array $data): array
    {
        return [
            'street'   => trim($data['street'] ?? ''),
            'number'   => trim($data['number'] ?? ''),
            'city'     => ucfirst(strtolower(trim($data['city'] ?? ''))),
            'zip_code' => trim($data['zip_code'] ?? ''),
            'country'  => ucfirst(strtolower(trim($data['country'] ?? ''))),
            'email'    => strtolower(trim($data['email'] ?? '')),
            'phone_1'  => trim($data['phone_1'] ?? ''),
            'phone_2'  => trim($data['phone_2'] ?? '')
        ];
    }
}
