<script src="<?php echo base_url() ?>assets/js/jquery.mask.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>

<!-- TODO: Validar -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>

<style>
    /* Hiding the checkbox, but allowing it to be focused */
    .badgebox {
        opacity: 0;
    }

    .badgebox+.badge {
        /* Move the check mark away when unchecked */
        text-indent: -999999px;
        /* Makes the badge's width stay the same checked and unchecked */
        width: 27px;
    }

    .badgebox:focus+.badge {
        /* Set something to make the badge looks focused */
        /* This really depends on the application, in my case it was: */
        /* Adding a light border */
        box-shadow: inset 0px 0px 5px;
        /* Taking the difference out of the padding */
    }

    .badgebox:checked+.badge {
        /* Move the check mark back when checked */
        text-indent: 0;
    }
</style>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-car"></i>
                </span>
                <h5>Editar Carro</h5>
                <div class="buttons">
                    <a title="Voltar" class="btn btn-mini btn-inverse" href="<?php echo site_url() ?>/clientes"><i class="fas fa-arrow-left"></i> Voltar</a>
                </div>
            </div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Informações Básica</a></li>
                <li><a data-toggle="tab" href="#menu2">Detalhes</a></li>
            </ul>
            <?php $_SESSION['clientes']['idClientes'] = $result->idClientes; ?>
            <form action="<?php echo current_url(); ?>" id="formCarro" method="post" class="form-horizontal">
                <div class="widget-content nopadding tab-content">
                    <?php if ($custom_error != '') {
                        echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                    } ?>
                    <div id="home" class="tab-pane fade in active">
                        <center><label id="lblRetorno"><b></b></label></center>
                        <div class="control-group">
                            <label for="cliente" class="control-label">Cliente</label>
                            <div class="controls">
                                <input id="cliente" class="cliente" type="text" name="cliente" value="<?php echo $results[0]->nomeCliente; ?>" />
                                <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value="<?php echo $result->idClientes; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo form_hidden('idCarros', $result->idCarros) ?>
                            <label for="placa" class="control-label">Placa<span class="required">*</span></label>
                            <div class="controls">
                                <input style="text-transform:uppercase" id="placa" class="placa" type="text" name="placa" value="<?php echo $result->placa; ?>" />
                                <button id="buscar_info_placa" class="btn btn-xs" type="button">Buscar Informações (Placa)</button>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="carro" class="control-label">Carro:</label>
                            <div class="controls">
                                <input id="carro" type="text" name="carro" value="<?php echo $result->carro; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="montadora" class="control-label">Montadora</label>
                            <div class="controls">
                                <input id="montadora" type="text" name="montadora" value="<?php echo $result->montadora; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="anoFabricacao" class="control-label">Ano Fabricação</label>
                            <div class="controls">
                                <input id="anoFabricacao" type="text" name="anoFabricacao" value="<?php echo $result->anoFabricacao; ?>" />
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="span12">
                                <div class="span6 offset3">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt"></i>
                                        Atualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Menu Detalhes -->
                    <div id="menu2" class="tab-pane fade">
                        <div class="control-group" class="control-label">
                            <label for="anoModelo" class="control-label">Ano Modelo</label>
                            <div class="controls">
                                <input id="anoModelo" type="text" name="anoModelo" value="<?php echo $result->anoModelo; ?>" />
                            </div>
                        </div>
                        <div class="control-group" class="control-label">
                            <label for="cor" class="control-label">Cor</label>
                            <div class="controls">
                                <input id="cor" type="text" name="cor" value="<?php echo $result->cor; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="chassi" class="control-label">Chassi</label>
                            <div class="controls">
                                <input id="chassi" type="text" name="chassi" value="<?php echo $result->chassi; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="municipio" class="control-label">Municipio</label>
                            <div class="controls">
                                <input id="municipio" type="text" name="municipio" value="<?php echo $result->municipio; ?>" />
                            </div>
                        </div>
                        <div class="control-group" class="control-label">
                            <label for="uf" class="control-label">Uf</label>
                            <div class="controls">
                                <input id="uf" type="text" name="uf" value="<?php echo $result->uf; ?>" />
                            </div>
                        </div>
                        <div class="control-group" class="control-label">
                            <label for="status" class="control-label">Status</label>
                            <div class="controls">
                                <input id="status" type="text" name="status" value="<?php echo $result->status; ?>" />
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="span12">
                                <div class="span6 offset3">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt"></i>
                                        Atualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.getJSON('<?php echo base_url() ?>assets/json/estados.json', function(data) {
            for (i in data.estados) {
                $('#estado').append(new Option(data.estados[i].nome, data.estados[i].sigla));
                var curState = '<?php echo $result->estado; ?>';
                if (curState) {
                    $("#estado option[value=" + curState + "]").prop("selected", true);
                }
            }
        });

        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/carros/autoCompleteCliente",
            minLength: 1,
            select: function(event, ui) {
                $("#clientes_id").val(ui.item.id);
                $idCliente = ui.item.id;
            }
        });

        $("#carro").focus();
        $('#formCarro').validate({
            rules: {
                nomeCliente: {
                    required: true
                },
            },
            messages: {
                nomeCliente: {
                    required: 'Campo Requerido.'
                },
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });
    });

    $("#placa").blur(function() {
        var placa = $(this).val().replace('-', '').toUpperCase();
        //Verifica se campo cep possui valor informado.
        if (placa != "" || placa == null) {
            var validaplaca = /(^[A-Z]{3}[0-9][A-Z][0-9]{2}$)|(^[A-Z]{3}[0-9]{4}$)/;
            if (validaplaca.test(placa)) {
                let url = "<?php echo base_url(); ?>index.php/carros/validaPlacaJaAssociadaACliente";
                return $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        id: $idCliente,
                        idplaca: placa.replace('-', '')
                    },
                    async: true,
                    success: function(res) {
                        var retorno = jQuery.parseJSON(res);
                        retorno.forEach(element => {
                            //console.log(element['placaExiste']);
                            if (element['placaExiste'] == 'sim') {
                                $("#lblRetorno").empty();
                                $("#lblRetorno").append($("<label><h6 style=color:red>*Placa já vinculada a outro cliente</h6>Tente Novamente!</label>").html());
                                setTimeout(function() {
                                    $("#lblRetorno").empty();
                                    $('input[type=text]').val('');
                                }, 3000);
                            }
                        });
                    }
                });
            } //end if.
            else {
                //Placa é inválida.
                Swal.fire({
                    type: "error",
                    title: "Atenção",
                    text: "Formato de Placa inválido."
                });
                $('input[type=text]').val('');
            }
        } //end if.
        else {
            Swal.fire({
                type: "error",
                title: "Atenção",
                text: "Digite uma placa para continuar"
            });
            //$('input[type=text]').val('');
        }
    });
</script>