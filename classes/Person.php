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
                    ORDER BY p.first_name, p.last_name ASC
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

    public function getPaginatedWithDetailsAndSearch(
        string $search,
        int $limit,
        int $offset,
        string $sort = 'last_name',
        string $dir = 'asc'
    ): array
    {
        $searchTerm = "%$search%";

        $allowedSorts = [
            'first_name' => 'p.first_name',
            'last_name'  => 'p.last_name',
            'nickname'   => 'p.nickname',
            'city'       => 'd.city',
            'email'      => 'd.email'
        ];

        $sortColumn = $allowedSorts[$sort] ?? $allowedSorts['last_name'];
        $dir = strtolower($dir) === 'desc' ? 'DESC' : 'ASC';

        $stmt = $this->db->prepare(
            "SELECT p.*, d.street, d.number, d.city, d.zip_code, d.country, d.email, d.phone_1, d.phone_2
            FROM person p
            LEFT JOIN person_details d ON p.id = d.person_id
            WHERE p.first_name LIKE :search OR p.last_name LIKE :search OR p.nickname LIKE :search OR d.email LIKE :search OR d.city LIKE :search
            ORDER BY {$sortColumn} {$dir}, p.id DESC
            LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountWithSearch(string $search): int
    {
        $searchTerm = "%$search%";

        $stmt = $this->db->prepare(
            "SELECT COUNT(*) 
            FROM person p
            LEFT JOIN person_details d ON p.id = d.person_id
            WHERE p.first_name LIKE :search OR p.last_name LIKE :search OR p.nickname LIKE :search OR d.email LIKE :search OR d.city LIKE :search"
        );

        $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }


    public function getAllWithDetails(): array
    {
        $stmt = $this->db->query(
            "SELECT p.*, d.street, d.number, d.city, d.zip_code, d.country, d.email, d.phone_1, d.phone_2
            FROM person p
            LEFT JOIN person_details d ON p.id = d.person_id
            ORDER BY p.first_name, p.last_name ASC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
