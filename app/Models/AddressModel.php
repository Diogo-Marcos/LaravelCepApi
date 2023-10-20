<?php

namespace App\Models;

class AddressModel {
    public static function findAddressByCEP($zipcode) {
        $api_url = "https://brasilaberto.com/api/v1/zipcode/" . $zipcode;

        $ch = curl_init($api_url);

        // Substitua "SeuTokenAqui" pelo seu token de API
        $token = "FSXD30EtLwNiOTNxJdwvrXwYvNFCtJzEpZOHJvPqVSyOiuVKZVa2yG8e6KNfsxia";

        // Configurar opções do cURL para incluir o cabeçalho de autenticação Bearer
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $token
        ));

        // Executar a solicitação à API
        $response = curl_exec($ch);

        // Verificar se a solicitação foi bem-sucedida
        if ($response !== false) {
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($http_status == 200) {
                // A solicitação foi bem-sucedida, processar a resposta
                $data = json_decode($response, true);

                // Verificar se a resposta contém dados de endereço
                if (isset($data['result'])) {
                    // Endereço encontrado, você pode acessar os campos do resultado
                    $address = $data['result'];

                    // Exemplo de como acessar campos específicos
                    $street = $address['street'];
                    $district = $address['district'];
                    $city = $address['city'];
                    $state = $address['state'];

                    // Fechar a sessão cURL
                    curl_close($ch);

                    return $address;
                } else {
                    // Endereço não encontrado, trate o erro, se necessário.
                    // Fechar a sessão cURL
                    curl_close($ch);

                    return null;
                }
            } elseif ($http_status == 404) {
                // CEP inexistente
                // Fechar a sessão cURL
                curl_close($ch);

                return null;
            } else {
                // Trate outros erros de resposta HTTP, se necessário.
                // Fechar a sessão cURL
                curl_close($ch);

                return null;
            }
        } else {
            // A solicitação cURL falhou, trate o erro, se necessário.
            // Fechar a sessão cURL
            curl_close($ch);

            return null;
        }
    }
}
