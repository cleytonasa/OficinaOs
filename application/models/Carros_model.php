<?php
class Carros_model extends CI_Model
{

    /**
     * author: Ramon Silva
     * email: silva018-mg@yahoo.com.br
     *
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idCarros', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result = !$one ? $query->result() : $query->row();
        return $result;
    }

    public function getById($id)
    {
        $this->db->where('idCarros', $id);
        $this->db->limit(1);
        return $this->db->get('carros')->row();
    }

    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    public function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        }

        return false;
    }

    public function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    /**
     * Retorna o Cliente vinculado ao Carro
     * @param int $id
     * @return array
     */
    public function getClienteByCarro($id)
    {
        $this->db->select('clientes.*');
        $this->db->from('clientes');
        $this->db->join('carros', 'carros.idClientes = clientes.idClientes');
        $this->db->where('carros.idCarros', $id);

        return $this->db->get()->result();
    }

    public function autoCompleteCliente($q)
    {
        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nomeCliente', $q);
        $this->db->or_like('telefone', $q);
        $this->db->or_like('celular', $q);
        $query = $this->db->get('clientes');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => $row['nomeCliente'] . ' | Telefone: ' . $row['telefone'] . ' | Celular: ' . $row['celular'], 'id' => $row['idClientes']];
            }
            echo json_encode($row_set);
        }
    }

    public function validaPlacaJaAssociadaACliente($data)
    {
        //echo json_encode($data);
        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('placa', $data['placa']);
        //$this->db->join('clientes', 'clientes.idClientes = carros.idClientes');
        $query = $this->db->get('carros');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => $row['carro'] . ' | placa: ' . $row['placa'] . ' | montadora: ' . $row['montadora'], 'id' => $row['idCarros'], 'placaExiste' => ['sim']];
            }
            echo json_encode($row_set);
        } else {
            $row_set[] = ['label' => ['carro'] . ' | placa: ' . ['placa'] . ' | montadora: ' . ['montadora'], 'id' => ['idCarros'], 'placaExiste' => ['não']];
            echo json_encode($row_set);
        }
    }
}
