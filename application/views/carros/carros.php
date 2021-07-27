<?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCarro')) { ?>
    <a href="<?php echo base_url(); ?>index.php/carros/adicionar" class="btn btn-success"><i class="fas fa-plus"></i> Adicionar Carro</a>
<?php } ?>

<div class="widget-box">
    <div class="widget-title">
        <span class="icon">
            <i class="fas fa-car"></i>
        </span>
        <h5>Carros</h5>
    </div>

    <div class="widget-content nopadding tab-content">
        <table id="tabela" class="table table-bordered ">
            <thead>
                <tr>
                    <th>Cod.</th>
                    <th>Carro</th>
                    <th>Placa.</th>
                    <th>Montadora</th>
                    <th>Ano (Fabricação / Modelo)</th>
                    <th>Cor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (!$results) {
                    echo '<tr>
                                <td colspan="5">Nenhum Carro Cadastrado</td>
                                </tr>';
                }
                foreach ($results as $r) {
                    echo '<tr>';
                    echo '<td>' . $r->idCarros . '</td>';
                    echo '<td><a href="' . base_url() . 'index.php/carros/visualizar/' . $r->idCarros . '" style="margin-right: 1%">' . $r->carro . '</a></td>';
                    echo '<td>' . $r->placa . '</td>';
                    echo '<td>' . $r->montadora . '</td>';
                    if ($r->anoFabricacao != null && $r->anoModelo != null) {
                        $ano = $r->anoFabricacao . ' / ' . $r->anoModelo;
                    } else {
                        $ano = $r->anoFabricacao;
                    };
                    echo '<td>' . $ano . '</td>';
                    echo '<td>' . $r->cor . '</td>';
                    echo '<td>';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCarro')) {
                        echo '<a href="' . base_url() . 'index.php/carros/visualizar/' . $r->idCarros . '" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="fas fa-eye"></i></a>';
                    }
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCarro')) {
                        echo '<a href="' . base_url() . 'index.php/carros/editar/' . $r->idCarros . '" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Carro"><i class="fas fa-edit"></i></a>';
                    }
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCarro')) {
                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" carro="' . $r->idCarros . '" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Carro"><i class="fas fa-trash-alt"></i></a>';
                    }
                    echo '</td>';
                    echo '</tr>';
                } ?>

            </tbody>
        </table>
    </div>
</div>
<?php echo $this->pagination->create_links(); ?>


<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/carros/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Carro</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idCarro" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir este Carro e os dados associados a ele (OS, Vendas, Receitas)?</h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Excluir</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var carro = $(this).attr('carro');
            $('#idCarro').val(carro);
        });
    });
</script>