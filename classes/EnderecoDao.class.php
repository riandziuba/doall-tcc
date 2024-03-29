<?php
    require_once('autoload.php');

    class EnderecoDao{
        /**
	 * INSERT
	 */

	public static function Insert(Endereco $endereco, $idUsuario) {
		return StatementBuilder::insert("INSERT INTO enderecos (CEP, rua, numero, bairro, complemento, cidade, referencia, idUsuario) VALUES (:CEP, :rua, :numero, :bairro, :complemento, :cidade, :referencia, :idUsuario)",
			[
				'CEP' => $endereco->getCep(),
				'rua' => $endereco->getRua(),
				'numero' => $endereco->getNumero(),
                'bairro' => $endereco->getBairro(),
                'complemento' => $endereco->getComplemento(),
                'cidade' => $endereco->getCidade(),
                'referencia' => $endereco->getReferencia(),
                'idUsuario' => $idUsuario
            ]
        );
    }
    
    /**
	 * SELECT
	 */

	public static function Popula($row)
	{
		$endereco = new Endereco;
		$endereco->setCodigo($row['id']);
		$endereco->setCep($row['CEP']);
		$endereco->setRua($row['rua']);
        $endereco->setNumero(($row['numero']));
        $endereco->setBairro($row['bairro']);
        $endereco->setComplemento($row['complemento']);
        $endereco->setCidade($row['cidade']);
        $endereco->setReferencia($row['referencia']);
		return $endereco;
	}

	public static function Select($criterio, $pesquisa)
	{
		try {
			switch ($criterio) {
                case 'rua':
                case 'bairro':
                case 'cidade':
                case 'complemento':
                case 'referencia':
					$sql = "SELECT * FROM enderecos WHERE $criterio like '%$pesquisa%'";
					break;

				case 'id':
                case 'CEP':
                case 'id_usuario':
                case 'numero':
					$sql = "SELECT * FROM enderecos WHERE $criterio = '$pesquisa'";
					break;

				case 'todos':
					$sql = "SELECT * FROM enderecos";
					break;
			}

			$query = Conexao::conexao()->query($sql);

			$usuarios = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($usuarios, self::Popula($row));
			}

			return $usuarios;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }
    
    /**
	 * UPDATE
	 */

	public static function Update(Endereco $endereco) {
		return StatementBuilder::update(
			"UPDATE enderecos SET CEP = :CEP, rua = :rua, numero = :numero, bairro = :bairro, complemento = :complemento, cidade = :cidade, referencia = :referencia WHERE id = :id",
			[
				'CEP' => $endereco->getCep(),
				'rua' => $endereco->getRua(),
				'numero' => $endereco->getNumero(),
                'bairro' => $endereco->getBairro(),
                'complemento' => $endereco->getComplemento(),
                'cidade' => $endereco->getCidade(),
                'referencia' => $endereco->getReferencia(),
                'id' => $endereco->getCodigo()
			]
		);
	}

    }
?>