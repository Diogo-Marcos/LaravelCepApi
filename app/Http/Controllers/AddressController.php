<?php

namespace App\Http\Controllers;
use App\Models\AddressModel;

class AddressController {
    public function searchAddress() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $zipcode = $_POST['zipcode'];

            // Chame o método do modelo para buscar o endereço com base no CEP
            $address = AddressModel::findAddressByCEP($zipcode);

            if ($address) {
                // Processar os dados do endereço
                return view('welcome', ['address' => $address]);
            } else {
                // Endereço não encontrado
                return null;
            }
    }
        }
    }

// Exemplo de uso:
$controller = new AddressController();
$controller->searchAddress();
