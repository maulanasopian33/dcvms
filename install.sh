#!/bin/bash

install_semua() {
    echo "Melakukan instalasi semua..."
    # Masukkan perintah instalasi untuk semua di sini
}

install_perintah1() {
    echo "Melakukan instalasi perintah 1..."
    # Masukkan perintah instalasi untuk perintah 1 di sini
}

pilihan=

echo "Menu Instalasi:"
echo "1. Install semua"
echo "2. Install perintah 1"
read -p "Masukkan pilihan (1/2): " pilihan

case $pilihan in
    1) install_semua;;
    2) install_perintah1;;
    *) echo "Pilihan tidak valid";;
esac
