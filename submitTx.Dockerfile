FROM registry.lidonation.com/lidonation/lidonation/ubuntu-ghc-cabal-libsodium-cardano:1.35.4 as base

FROM ubuntu:20.04

SHELL ["/bin/bash", "-c"]

RUN apt-get update -y \
  && DEBIAN_FRONTEND="noninteractive" apt-get install -y \
    sudo libssl-dev iproute2 libssl-dev jq bc git libtool

# Install libsodium
RUN git clone https://github.com/input-output-hk/libsodium \
    && cd libsodium \
    && git checkout 66f017f1 \
    && ./autogen.sh \
    && ./configure \
    && make \
    && make install \
    && cd .. && rm -rf libsodium

EXPOSE 8080

# Add scripts
ADD src/pool/scripts/ /scripts/

RUN mkdir -p /config # && apt-get install sqlite3
COPY src/pool/config/build/ /config/
COPY src/pool/cntools/ /cntools/

COPY --from=base /root/.cabal/bin/ /scripts/

ENV PATH="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/scripts"

#RUN cd /scripts && wget https://hydra.iohk.io/build/16159630/download/1/cardano-node-1.35.4-linux.tar.gz &&\
#    tar -xf cardano-node-1.35.4-linux.tar.gz &&\
#    rm cardano-node-1.35.4-linux.tar.gz

WORKDIR /scripts

RUN chmod -R +x /scripts/

RUN useradd -ms /bin/bash cardano-node \
    && echo "cardano-node ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/cardano-node \
    && chmod 0440 /etc/sudoers.d/cardano-node \
    && chown cardano-node /config

CMD ["/bin/bash", "/scripts/entrypoint", "--start"]
