FROM registry.lidonation.com/lidonation/lidonation/ubuntu-ghc-cabal-libsodium-cardano:1.35.4

SHELL ["/bin/bash", "-c"]
# Expose ports
EXPOSE 8080

# Add scripts
RUN mkdir -p /config # && apt-get install sqlite3
COPY src/pool/config/build/ /config/
COPY src/pool/cntools/ /cntools/
ADD src/pool/scripts/ /scripts/
RUN cd /scripts && wget https://hydra.iohk.io/build/16159630/download/1/cardano-node-1.35.4-linux.tar.gz &&\
    tar -xf cardano-node-1.35.4-linux.tar.gz &&\
    rm cardano-node-1.35.4-linux.tar.gz

RUN chmod -R +x /scripts/

CMD ["/bin/bash", "entrypoint", "--start"]
