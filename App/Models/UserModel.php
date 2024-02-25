<?php

namespace App\Models;

class UserModel
{
    const TABLE = "users";
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * auth login
     * @param array $creds
     */
    public function auth($creds)
    {
        $statement = $this->db->prepare("SELECT * FROM " . self::TABLE . " WHERE email = :email");
        $statement->bindValue(':email', $creds['email']);
        $statement->execute();

        if ($statement->rowCount() === 0) {
            return [
                "status"    => false,
                "message"   => "E-mail não registrado!",
                "class"     => "danger"
            ];
        }

        $data = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($data['password'] != md5($creds['password'])) {
            return [
                "status"    => false,
                "message"   => "Senha incorreta!",
                "class"     => "danger"
            ];
        }

        $_SESSION['user'] = $data['id'];

        return [
            "status"    => true,
            "message"   => "Logado com sucesso!",
            "class"     => "success"
        ];
    }

    /**
     * register
     * @param array $params
     */
    public function set($params)
    {
        $fields = [];
        foreach ($params as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
        $sql = $this->db->prepare("INSERT INTO " . self::TABLE . " SET {$fields}");

        foreach ($params as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
        $sql->execute();
    }

    /**
     * update
     * @param array $params
     */
    public function update($params)
    {
        $fields = [];
        foreach ($params as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
        $sql = $this->db->prepare("UPDATE " . self::TABLE . " SET {$fields} WHERE id = :id");

        $sql->bindValue(":id", $params['id']);
        foreach ($params as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
        $sql->execute();
    }

    /**
     * list users
     */
    public function getAll()
    {
        $statement = $this->db->prepare("SELECT * FROM " . self::TABLE . " ORDER BY name ASC");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * get find user by ID
     * @param int $id
     */
    public function find($id)
    {
        $statement = $this->db->prepare("SELECT * FROM " . self::TABLE . " WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * verify email
     * @param string $email
     * @param int $id
     */
    public function hasEmail($email, $id = "")
    {
        $statement = "SELECT * FROM " . self::TABLE . " WHERE email = :email";
        if (!empty($id)) {
            $statement .= " AND id != :id";
        }
        $statement = $this->db->prepare($statement);
        $statement->bindValue(':email', $email);
        if (!empty($id)) {
            $statement->bindValue(':id', $id);
        }
        $statement->execute();
        return $statement->rowCount() ?? false;
    }

    /**
     * Verificar se o usuário possui uma permissão específica
     * @param int $userId ID do usuário
     * @param string $resource Nome do recurso (por exemplo, 'admin')
     * @param string $permission Permissão necessária (por exemplo, 'access')
     * @return bool Retorna true se o usuário tiver a permissão, false caso contrário
     */
    public function hasPermission($userId, $resource, $permission)
    {
        $statement = $this->db->prepare(
            "SELECT COUNT(*) as count FROM permissions 
            WHERE user_id = :user_id 
            AND resource = :resource 
            AND permission = :permission"
        );
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':resource', $resource);
        $statement->bindValue(':permission', $permission);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return ($result['count'] > 0);
    }
}
