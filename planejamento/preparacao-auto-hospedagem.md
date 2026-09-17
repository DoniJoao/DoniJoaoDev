# preparacao-auto-hospedagem

peguntei a cada uma das IA´s, o seguinte:

pretendo hospedar meu site em casa, no meu antigo i3 de 3º geração, estou ciente dos riscos e preparos que devo tomar para executar tal proeza, mas se é possivel fazer de forma funcional e segura, eu vou tentar.
minha pergunta a vocé é:
hospedo no Debian que roda no meu WSL, dentro do windows ?
instalo o Debian ( ou alguma outra distro mais adequada) diretamente na maquina (direto sem virtualização) ?

segue as respostas de cada uma:

## Claude

Direto ao ponto: instale o Debian direto na máquina. WSL não é o lugar pra isso.

O WSL é um ambiente de desenvolvimento, não de produção. Os problemas são estruturais, não de configuração:

A distro só sobe quando você abre um terminal — ela não é um serviço que inicia com o boot. Se faltar luz e a máquina voltar sozinha, o Windows entra na tela de login e o seu site simplesmente não existe até alguém sentar e digitar a senha. Dá pra contornar com tarefa agendada, mas é gambiarra em cima de gambiarra.

A rede é NAT com IP interno que muda a cada reinício. Pra alguém de fora alcançar o Apache dentro do WSL você precisa de netsh portproxy no Windows apontando pro IP da VM — e esse proxy quebra toda vez que o IP muda. É a receita pra um site que cai sozinho na terça-feira sem motivo aparente.

Some a isso o Windows reiniciando pra atualizar, suspendendo disco, antivírus travando I/O, e a camada de virtualização comendo RAM que num i3 antigo é justamente o recurso escasso. Você teria dois sistemas operacionais pra manter atualizados e endurecer, em vez de um.

Sobre a distro: Debian estável é a escolha certa, sem ironia. É exatamente pra isso que ele existe — pacotes conservadores, updates de segurança por anos, zero surpresa. Instale a versão sem ambiente gráfico (só "SSH server" e "utilitários padrão" na tela de tasksel). Um i3 de 3ª geração com 8 GB e um SSD roda um site PHP com folga absoluta; o gargalo será sua internet, nunca a CPU. Se quiser algo além no futuro, Proxmox permite VMs, mas pra um site só é complexidade sem retorno.

Agora, o obstáculo que provavelmente vai te morder antes de tudo isso: CGNAT. A maioria das operadoras residenciais no Brasil compartilha um IP público entre vários clientes, e nesse caso não existe porta pra redirecionar — nenhuma configuração no roteador resolve. Antes de formatar qualquer coisa, compare o IP que aparece em "qual é meu IP" com o IP da WAN na interface do seu roteador. Se forem diferentes, você está atrás de CGNAT. A saída é pedir IP público à operadora (às vezes gratuito, às vezes só no plano empresarial) ou usar um Cloudflare Tunnel, que aliás tem uma vantagem boa: seu IP residencial nunca fica exposto e você não abre porta nenhuma no roteador. Vale conferir também se a operadora bloqueia as portas 80 e 443 de entrada, o que é comum.

O resto do caminho, em ordem: IP fixo na LAN pro servidor, SSH só com chave e sem login de root, ufw liberando apenas 22/80/443, fail2ban, nginx com php-fpm (mais leve que Apache nessa máquina), MariaDB escutando só em 127.0.0.1, Certbot pro HTTPS, unattended-upgrades pros patches de segurança, DDNS se o IP for dinâmico, e backup do banco pra fora da casa — porque disco de máquina velha morre.

Uma última coisa, já que é sobre o seu código: com o site aberto pra internet, aquele admin_post_criar que joga $_POST['titulo'] direto no banco e as views que ecoam o conteúdo vão receber visita de bots em questão de horas. Antes de expor, garanta que os models usam prepared statements de verdade e que toda saída passa por htmlspecialchars(). É mais provável você ser invadido por SQL injection no formulário do que por alguém forçando seu SSH.

## Gemini

Para um servidor caseiro, especialmente rodando em um i3 de 3ª geração, a resposta é muito clara: Instale o Debian (ou outra distro de servidor) diretamente na máquina (bare metal).

Usar o WSL para hospedar um site público em produção, embora seja possível como experimento, vai te trazer mais dores de cabeça do que benefícios práticos.

Aqui estão os motivos técnicos do porquê a instalação direta é infinitamente superior para o seu caso:

1. Consumo de Recursos (O Gargalo do i3)
Um i3 de 3ª geração é um processador valente, mas já tem suas limitações. Se você usar o WSL, terá que manter o Windows rodando por baixo. O Windows 10/11 consome facilmente 2GB a 3GB de RAM e bastante tempo de CPU apenas para se manter ligado.
Se você instalar um Debian Server (sem interface gráfica) direto na máquina, o sistema operacional inteiro vai consumir cerca de 150MB a 200MB de RAM quando ocioso. Isso deixa quase 100% do seu hardware livre para processar as requisições do seu site, executar seus scripts PHP e manter o banco de dados MySQL rápido.

2. Rede e Redirecionamento de Portas (A dor de cabeça do WSL)
Para hospedar um site em casa, você precisa fazer o Port Forwarding (redirecionamento das portas 80 e 443) no seu roteador para o IP da máquina.
O WSL2 usa uma arquitetura de rede virtualizada (NAT). Isso significa que o WSL tem um IP diferente do seu Windows. Você teria que redirecionar do roteador para o Windows, e depois configurar o Windows para redirecionar para o WSL. Além de complexo, o IP do WSL muda a cada reinicialização, quebrando tudo. No Debian instalado direto, a máquina ganha um IP local fixo no roteador e a configuração é direta.

3. Estabilidade e Uptime
O Windows foi feito para desktop. Ele vai baixar atualizações, entrar em modo de suspensão, e eventualmente reiniciar sozinho de madrugada para aplicar patches. Seu site vai cair. O Debian puro pode ficar ligado por meses ou anos sem precisar de uma única reinicialização não programada.

Qual Distribuição Escolher?
Vá de Debian (usando a imagem netinst) ou Ubuntu Server.
Como você tem facilidade com terminal de comandos, Git e ambientes de desenvolvimento, recomendo fortemente não instalar a interface gráfica (Desktop Environment). Administre tudo via SSH. Seu i3 vai agradecer imensamente por não ter que renderizar janelas.

O "Caminho das Pedras" Seguro
Já que você vai fazer de forma funcional e segura, aqui está o roteiro de ouro para quem hospeda em casa:

IP Dinâmico: A internet da sua casa provavelmente muda de IP (IP Dinâmico). Você precisará usar um serviço de DDNS (como DuckDNS, No-IP ou Cloudflare DDNS) rodando no Debian para atualizar seu IP público automaticamente.

Cloudflare: Não aponte seu domínio diretamente para o IP da sua casa. Passe o domínio pelo Cloudflare (plano gratuito). O Cloudflare funciona como um escudo (proxy): os visitantes acessam o IP do Cloudflare, que busca os dados no seu i3. Isso esconde o seu IP real da internet (evitando ataques diretos à sua rede) e já te entrega um certificado SSL (HTTPS) de forma muito mais fácil.

Segurança Básica no Debian:

Mude a porta padrão do SSH (de 22 para outra).

Desative o login de root por SSH.

Configure o UFW (Firewall) para liberar apenas as portas necessárias (SSH, 80 e 443).

Com esse setup direto no hardware, seu i3 de 3ª geração vai rodar bancos de dados PDO e sistemas web com folga e de maneira muito profissional!

## DeepSeek

