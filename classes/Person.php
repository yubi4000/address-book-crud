<?php

class Person
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM person ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM person WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO person (first_name, last_name, nickname)
             VALUES (:first_name, :last_name, :nickname)"
        );

        $stmt->execute([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'nickname'   => $data['nickname'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE person
             SET first_name = :first_name,
                 last_name  = :last_name,
                 nickname   = :nickname
             WHERE id = :id"
        );

        return $stmt->execute([
            'id'         => $id,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'nickname'   => $data['nickname'],
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM person WHERE id = :id"
        );
        return $stmt->execute(['id' => $id]);
    }

    // pagination
    public function getPaginatedWithDetails(int $limit, int $offset): array
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, d.street, d.number, d.city, d.zip_code, d.country, d.email, d.phone_1, d.phone_2
            FROM person p
            LEFT JOIN person_details d ON p.id = d.person_id
            ORDER BY p.last_name, p.first_name
            LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCount(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM person");
        return (int) $stmt->fetchColumn();
    }

    public function getAllWithDetails(): array
    {
        $stmt = $this->db->query(
            "SELECT p.*, d.street, d.number, d.city, d.zip_code, d.country, d.email, d.phone_1, d.phone_2
            FROM person p
            LEFT JOIN person_details d ON p.id = d.person_id
            ORDER BY p.last_name, p.first_name"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

