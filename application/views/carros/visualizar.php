<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Carro</a></li>
            <li><a data-toggle="tab" href="#tab2">Dados do Cliente</a></li>
            <div class="buttons">
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCarro')) {
                    echo '<a title="Icon Title" class="btn btn-mini btn-info" href="' . base_url() . 'index.php/carros/editar/' . $result->idCarros . '"><i class="fas fa-edit"></i> Editar</a>';
                } ?>
                <a title="Voltar" class="btn btn-mini btn-inverse" href="<?php echo site_url() ?>/carros"><i class="fas fa-arrow-left"></i> Voltar</a>
            </div>
        </ul>
    </div>
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">
            <div class="accordion" id="collapse-group">
                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                <span class="icon"><i class="fas fa-car"></i></span>
                                <h5>Dados - (<?php echo $result->carro;
                                                echo " / ";
                                                echo $result->placa ?>)</h5>
                            </a>
                        </div>
                    </div>
                    <div class="collapse in accordion-body" id="collapseGOne">
                        <div class="widget-content">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td style="text-align: right; width: 30%"><strong>Carro</strong></td>
                                        <td>
                                            <?php
                                            echo $result->carro;
                                            ?>
                                            <?php
                                            // Talvez exita forma melhor de fazer isso, verificar
                                            $_SESSION['clientes']['idClientes'] = $result->idClientes;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Placa</strong></td>
                                        <td>
                                            <?php echo $result->placa ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Montadora</strong></td>
                                        <td>
                                            <?php echo $result->montadora ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Ano (Fabricação / Modelo)</strong></td>
                                        <td>
                                            <?php
                                            if ($result->anoFabricacao != null && $result->anoModelo != null) {
                                                $ano = $result->anoFabricacao . ' / ' . $result->anoModelo;
                                            } else {
                                                $ano = $result->anoFabricacao;
                                            };
                                            echo $ano;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Cor</strong></td>
                                        <td>
                                            <?php echo $result->cor ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Chassi</strong></td>
                                        <td>
                                            <?php echo $result->chassi ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Municipio</strong></td>
                                        <td>
                                            <?php echo $result->municipio ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Uf</strong></td>
                                        <td>
                                            <?php echo $result->uf ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Data Cadastro / Data Modificação</strong></td>
                                        <td>
                                            <?php
                                            if ($result->dataCadastro != null && $result->dataModificacao != null) {
                                                $data = $result->dataCadastro . ' / ' . $result->dataModificacao;
                                            } else {
                                                $data = $result->dataCadastro;
                                            };
                                            echo date('d/m/Y', strtotime($data)) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Status</strong></td>
                                        <td>
                                            <?php echo $result->status ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Tab 2-->
        <div id="tab2" class="tab-pane" style="min-height: 300px">
            <?php if (!$results) { ?>
                <table class="table table-bordered ">
                    <thead>
                        <tr style="backgroud-color: #2D335B">
                            <th>Cod.</th>
                            <th>Nome</th>
                            <th>CPF/CNPJ</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">Nenhum Cliente Associado (isso seria um problema)</td>
                        </tr>
                    </tbody>
                </table>
            <?php
            } else { ?>
                <table class="table table-bordered ">
                    <thead>
                        <tr style="backgroud-color: #2D335B">
                            <th>Cod.</th>
                            <th>Nome</th>
                            <th>CPF/CNPJ</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($results as $r) {
                            $dataInicial = date(('d/m/Y'), strtotime($r->dataInicial));
                            $dataFinal = date(('d/m/Y'), strtotime($r->dataFinal));
                            echo '<tr>';
                            echo '<td>' . $r->idClientes . '</td>';
                            echo '<td>' . $r->nomeCliente . '</td>';
                            echo '<td>' . $r->documento . '</td>';
                            echo '<td>' . $r->telefone . '</td>';
                            echo '<td>' . $r->email . '</td>';

                            echo '<td>';
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
                                echo '<a href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="fas fa-eye"></i></a>';
                            }
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
                                echo '<a href="' . base_url() . 'index.php/clientes/editar/' . $r->idClientes . '" class="btn btn-info tip-top" title="Editar Cliente"><i class="fas fa-edit"></i></a>';
                            }

                            echo  '</td>';
                            echo '</tr>';
                        } ?>
                        <tr>
                        </tr>
                    </tbody>
                </table>
            <?php
            } ?>
        </div>
    </div>
</div>