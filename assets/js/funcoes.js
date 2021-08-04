$(function () {
    $("#celular").mask("(00)00000-0000")
    $("#cep").mask("00000-000")
    $('#cpfUser').mask('000.000.000-00', { reverse: true });
    $('.cnpjEmitente').mask('00.000.000/0000-00', { reverse: true });
    $("#placa").mask("AAA-9A99", { placeholder: "" });
    $("#buscaPlaca").mask("AAA-9A99", { placeholder: "" });

    // $('input[name=buscaPlaca]').mask('AAA-0U00', {
    //     translation: {
    //         'A': {
    //             pattern: /[A-Za-z]/
    //         },
    //         'U': {
    //             pattern: /[A-Za-z0-9]/
    //         },
    //     },
    //     onKeyPress: function(value, e, field, options) {
    //         // Convert to uppercase
    //         e.currentTarget.value = value.toUpperCase();

    //         // Get only valid characters
    //         let val = value.replace(/[^\w]/g, '');

    //         // Detect plate format
    //         let isNumeric = !isNaN(parseFloat(val[4])) && isFinite(val[4]);
    //         let mask = 'AAA 0U00';
    //         if (val.length > 4 && isNumeric) {
    //             mask = 'AAA-0000';
    //         }
    //         $(field).mask(mask, options);
    //         $('#modal-carro').modal('show');
    //     }
    // });
});


$(function () {
    if ($('.cpfcnpjmine').val() != null) {
        if ($('.cpfcnpjmine').val() != "") {
            $(".cpfcnpjmine").prop('readonly', true);
        }
    }
    if ($('.cpfUser').val() != null) {
        var cpfUser = $('.cpfUser').val().length;
        if (cpfUser == "14") {
            $(".cpfUser").prop('readonly', true);
        }
    }

});

$(function () {
    var telefoneN = function (val) {
        return val.replace(/\D/g, '').length > 10 ? '(00)00000-0000' : '(00)0000-00009';
    },
        telefoneOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(telefoneN.apply({}, arguments), options);
            },
        };
    $('#telefone').mask(telefoneN, telefoneOptions);
    $('#telefone').on('paste', function (e) {
        e.preventDefault();
        var clipboardCurrentData = (e.originalEvent || e).clipboardData.getData('text/plain');
        $('#telefone').val(clipboardCurrentData);
    });

});

$(function () {
    // INICIO FUNÇÃO DE MASCARA CPF/CNPJ
    var cpfMascara = function (val) {
        return val.replace(/\D/g, '').length > 11 ? '00.000.000/0000-00' : '000.000.000-009';
    },
        cpfOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(cpfMascara.apply({}, arguments), options);
            },
        };
    $('.cpfcnpj').mask(cpfMascara, cpfOptions);
    $('.cpfcnpj').on('paste', function (e) {
        e.preventDefault();
        var clipboardCurrentData = (e.originalEvent || e).clipboardData.getData('text/plain');
        $('.cpfcnpj').val(clipboardCurrentData);
    });
    // FIM FUNÇÃO DE MASCARA CPF/CNPJ
});

$(document).ready(function () {
    if ($("[name='idClientes']").val()) {
        $("#nomeCliente").focus();
    } else {
        $("#documento").focus();
    }

    function limpa_formulario_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#estado").val("");
    }

    function capitalizeFirstLetter(string) {
        if (typeof string === 'undefined') {
            return;
        }

        return string.charAt(0).toUpperCase() + string.slice(1).toLocaleLowerCase();
    }

    function capital_letter(str) {
        if (typeof str === 'undefined') { return; }
        str = str.toLocaleLowerCase().split(" ");

        for (var i = 0, x = str.length; i < x; i++) {
            str[i] = str[i][0].toUpperCase() + str[i].substr(1);
        }

        return str.join(" ");
    }

    function validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, '');

        if (cnpj == '') return false;

        if (cnpj.length != 14) return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;

        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0, tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;

        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }

        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

        if (resultado != digitos.charAt(1))
            return false;

        return true;
    }

    $('#buscar_info_cnpj').on('click', function () {
        //Nova variável "ndocumento" somente com dígitos.
        var ndocumento = $('#documento').val().replace(/\D/g, '');

        if (validarCNPJ(ndocumento)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            $("#nomeCliente").val("...");
            $("#email").val("...");
            $("#cep").val("...");
            $("#rua").val("...");
            $("#numero").val("...");
            $("#bairro").val("...");
            $("#cidade").val("...");
            $("#estado").val("...");
            $("#complemento").val("...");
            $("#telefone").val("...");
            //Consulta o webservice receitaws.com.br/
            $.ajax({
                url: "https://www.receitaws.com.br/v1/cnpj/" + ndocumento,
                dataType: 'jsonp',
                crossDomain: true,
                contentType: "text/javascript",
                success: function (dados) {
                    if (dados.status == "OK") {
                        //Atualiza os campos com os valores da consulta.
                        if ($("#nomeCliente").val() != null) {
                            $("#nomeCliente").val(capital_letter(dados.nome));
                        }
                        if ($("#nomeEmitente").val() != null) {
                            $("#nomeEmitente").val(capital_letter(dados.nome));
                        }
                        $("#cep").val(dados.cep.replace(/\./g, ''));
                        $("#email").val(dados.email.toLocaleLowerCase());
                        $("#telefone").val(dados.telefone.split("/")[0].replace(/\ /g, ''));
                        $("#rua").val(capital_letter(dados.logradouro));
                        $("#numero").val(dados.numero);
                        $("#bairro").val(capital_letter(dados.bairro));
                        $("#cidade").val(capital_letter(dados.municipio));
                        $("#estado").val(dados.uf);
                        if (dados.complemento != "") {
                            $("#complemento").val(capital_letter(dados.complemento));
                        } else {
                            $("#complemento").val("");
                        }

                        // Força uma atualizacao do endereco via cep
                        document.getElementById("cep").focus();
                        if ($("#nomeCliente").val() != null) {
                            document.getElementById("nomeCliente").focus();
                        }
                        if ($("#nomeEmitente").val() != null) {
                            document.getElementById("nomeEmitente").focus();
                        }
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        if ($("#nomeCliente").val() != null) {
                            $("#nomeCliente").val("");
                        }
                        if ($("#nomeEmitente").val() != null) {
                            $("#nomeEmitente").val("");
                        }
                        $("#cep").val("");
                        $("#email").val("");
                        $("#numero").val("");
                        $("#complemento").val("");
                        $("#telefone").val("");

                        Swal.fire({
                            type: "warning",
                            title: "Atenção",
                            text: "CNPJ não encontrado."
                        });
                    }
                },
                error: function () {
                    ///CEP pesquisado não foi encontrado.
                    if ($("#nomeCliente").val() != null) {
                        $("#nomeCliente").val("");
                    }
                    if ($("#nomeEmitente").val() != null) {
                        $("#nomeEmitente").val("");
                    }
                    $("#cep").val("");
                    $("#email").val("");
                    $("#numero").val("");
                    $("#complemento").val("");
                    $("#telefone").val("");

                    Swal.fire({
                        type: "warning",
                        title: "Atenção",
                        text: "CNPJ não encontrado."
                    });
                },
                timeout: 2000,
            });
        } else {
            Swal.fire({
                type: "warning",
                title: "Atenção",
                text: "CNPJ inválido!"
            });
        }
    });

    // Busca Placa
    function buscaPlaca(placa) {
        //var ndocumento = placa.replace('-', '').toLocaleUpperCase();

        if (validarPlaca(placa)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            $("#carro").val("...");
            $("#montadora").val("...");
            $("#anoFabricacao").val("...");

            $("#anoModelo").val("...");
            $("#cor").val("...");
            $("#chassi").val("...");
            $("#municipio").val("...");
            $("#uf").val("...");
            $("#statusPlaca").val("...");

            //Consulta o webservice receitaws.com.br/
            $.ajax({
                url: "https://apicarros.com/v2/consultas/" + placa + "/f63e1e63dd231083d38ce929984aac7d",
                dataType: 'json',
                crossDomain: true,
                //contentType: "text/javascript",
                success: function (dados) {
                    if (dados.codigoRetorno == "0" || dados.codigoSituacao == "0") {
                        //Atualiza os campos com os valores da consulta.
                        montadora = (dados.modelo.split("/")[0]);
                        if (montadora == "" || montadora == null) {
                            montadora = dados.marca;
                        };
                        // Carro
                        if (dados.extra.marca_modelo.grupo != "" || dados.extra.marca_modelo.grupo != null) {
                            carro = dados.extra.marca_modelo.grupo;
                        } else if (dados.modelo.substring(dados.modelo.indexOf("/") + 1) != "" || dados.modelo.substring(dados.modelo.indexOf("/") + 1) != null) {
                            carro = dados.modelo.substring(dados.modelo.indexOf("/") + 1);
                        } else {
                            carro = dados.modelo;
                        }
                        // Chassi
                        if (dados.extra.chassi != "" || dados.extra.chassi != null) {
                            chassi = dados.extra.chassi;
                        } else {
                            chassi = dados.chassi;
                        };
                        // Ano Fabricação
                        if (dados.ano == "" || dados.ano == null || dados.ano == "null") {
                            ano = dados.anoModelo;
                        } else {
                            ano = dados.ano;
                        };

                        $("#carro").val(capitalizeFirstLetter(carro));
                        $("#montadora").val(capitalizeFirstLetter(montadora));
                        $("#anoFabricacao").val(ano);

                        $("#anoModelo").val(dados.anoModelo);
                        $("#cor").val(capitalizeFirstLetter(dados.cor));
                        $("#chassi").val(chassi);
                        $("#municipio").val(capitalizeFirstLetter(dados.municipio));
                        $("#uf").val(dados.uf);
                        $("#statusPlaca").val(capitalizeFirstLetter(dados.situacao));
                        //document.getElementById("nomeCliente").focus();
                        
                    } //end if.
                    else {
                        //Placa pesquisada não foi encontrada.
                        $("#carro").val("");
                        $("#montadora").val("");
                        $("#anoFabricacao").val("");
                        $("#anoModelo").val("");
                        $("#cor").val("");
                        $("#chassi").val("");
                        $("#municipio").val("");
                        $("#uf").val("");
                        $("#statusPlaca").val("");
                        $('#modal-carro').modal('hide');
                        Swal.fire({
                            type: "warning",
                            title: "Atenção (" + placa + ")",
                            text: "Placa não encontrada."
                        });
                    }
                },
                error: function () {
                    ///Placa pesquisada com erro.
                    $("#carro").val("");
                    $("#montadora").val("");
                    $("#anoFabricacao").val("");
                    $("#anoModelo").val("");
                    $("#cor").val("");
                    $("#chassi").val("");
                    $("#municipio").val("");
                    $("#uf").val("");
                    $("#statusPlaca").val("");
                    $('#modal-carro').modal('hide');
                    Swal.fire({
                        type: "error",
                        title: "Atenção (" + placa + ")",
                        text: "Erro: Placa não encontrada."
                    });
                },
                timeout: 2000,
            });
        } else {
            $('#modal-carro').modal('hide');
            Swal.fire({
                type: "warning",
                title: "Atenção",
                text: "Placa inválida!"
            });
        }
    };
    $('#buscar_info_placa').on('click', function () {
        //Nova variável "ndocumento" somente com dígitos.
        var placa = $('#placa').val().replace('-', '').toLocaleUpperCase();
        buscaPlaca(placa);
    });

    function validarPlaca(placa) {
        placa = placa.replace('-', '');

        if (placa == '') return false;

        if (placa.length != 7) return false;

        // Elimina Placas invalidas conhecidas
        if (placa == "AAA1234" ||
            placa == "ABC1234")
            return false;
        return true;
    };

    //Quando o campo cep perde o foco.
    $("#cep").blur(function () {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.

            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.

            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#estado").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep.replace(/\./g, '') + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulario_cep();
                        Swal.fire({
                            type: "warning",
                            title: "Atenção",
                            text: "CEP não encontrado."
                        });
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulario_cep();
                Swal.fire({
                    type: "error",
                    title: "Atenção",
                    text: "Formato de CEP inválido."
                });
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulario_cep();
        }
    });
});