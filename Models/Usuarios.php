<?php
namespace Models;

use \Core\ModelGeral;

class Usuarios extends ModelGeral {

	public function getTotalUsuarios() {
		$sql = $this->db->query("SELECT COUNT(*) as c FROM usuarios");
		$row = $sql->fetch();

		return $row['c'];
	}

	public function cadastrar($nome, $email, $senha, $telefone) {
		$sql = $this->db->prepare("SELECT id FROM usuarios WHERE email = :email");
		$sql->bindValue(":email", $email);
		$sql->execute();

		if($sql->rowCount() == 0) {

			$sql = $this->db->prepare("INSERT INTO usuarios(nome, email, senha, telefone) VALUES(:nome, :email, :senha, :telefone)");
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":email", $email);
			$sql->bindValue(":senha", md5($senha));
			$sql->bindValue(":telefone", $telefone);
			$sql->execute();

			return true;

		} else {
			return false;
		}

	}

	public function login($email, $senha) {
		$sql = $this->db->prepare("SELECT id FROM usuarios WHERE email = :email AND senha = :senha");
		$sql->bindValue(":email", $email);
		$sql->bindValue(":senha", md5($senha));
		$sql->execute();

		if($sql->rowCount() > 0) {
			$dado = $sql->fetch();
			$_SESSION['cLogin'] = $dado['id'];
			return true;
		} else {
			return false;
		}

	}
}
?>