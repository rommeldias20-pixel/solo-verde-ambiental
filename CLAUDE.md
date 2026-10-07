# Site Solo Verde Ambiental

Site institucional da Solo Verde Ambiental (hidrossemeadura, revegetação e controle de erosão em MG).

## Publicação
- Repositório: github.com/rommeldias20-pixel/solo-verde-ambiental
- **Push na `main` publica o site no ar** (soloverdeambiental.com.br, Hostinger, deploy automático para `public_html`). Só fazer push de mudanças conferidas.
- GitHub Pages foi abandonado; não reativar.

## Estrutura
- `index.html` — o site inteiro em um único arquivo, sem build.
- `Solo Verde Ambiental.md` — conteúdo do site em texto.
- `obras/` — fotos do portfólio (diário de obra de Iapu e Igarapé).
- `proposta.html` — versão antiga da proposta comercial; a versão em uso fica no app (`../solo-verde-app`).
- Fora do git (ver `.gitignore`): `video hero.MP4` (original de 79 MB), `antes.jpeg`, `durante.jpeg`, `IAPU-MG/`, `IGARAPÉ-MG/` (fotos brutas).

## Regras
- Preços e dados de clientes nunca vão para o repositório.
- Domínio e e-mail ficam na Hostinger: nunca alterar registros MX, SPF, DMARC ou DKIM.
- Imagens novas: comprimir antes de colocar no site.

## Testar
Preview `site` em `.claude/launch.json` (python3 -m http.server 8765). Conferir também em largura de celular.
