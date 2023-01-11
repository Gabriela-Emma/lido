FROM registry.lidonation.com/lidonation/lidonation/ubuntu-ghc-cabal-libsodium-cardano:1.35.4

SHELL ["/bin/bash", "-c"]

EXPOSE 8080

# Add scripts
ADD src/pool/scripts/ /scripts/

RUN mkdir -p /config && apt-get update && apt-get install sudo -y

COPY src/pool/config/build/ /config/
COPY src/pool/cntools/ /cntools/

RUN chmod -R +x /scripts/

#RUN cd /scripts && wget https://hydra.iohk.io/build/16159630/download/1/cardano-node-1.35.4-linux.tar.gz &&\
#    tar -xf cardano-node-1.35.4-linux.tar.gz &&\
#    rm cardano-node-1.35.4-linux.tar.gz

WORKDIR /scripts


ENV PATH="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/root/.cabal/bin:/root/.ghcup/bin:/root/.local/bin:/scripts:/scripts/functions"

RUN useradd -ms /bin/bash cardano-node \
    && echo "cardano-node ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/cardano-node \
    && chmod 0440 /etc/sudoers.d/cardano-node \
    && chown cardano-node /config

CMD ["/bin/bash", "/entrypoint", "--start"]
