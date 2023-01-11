FROM ubuntu:20.04
LABEL maintainer="darlington@raddcreative.com"

# Install build dependencies
#
RUN apt-get update -y \
    && DEBIAN_FRONTEND="noninteractive" apt-get install -y \
        automake \
        build-essential \
        pkg-config \
        libffi-dev \
        dnsutils \
        libgmp-dev \
        libssl-dev \
        libtinfo-dev \
        libsystemd-dev \
        zlib1g-dev \
        make \
        g++ \
        tmux \
        git \
        jq \
        wget \
        libncursesw5 \
        bc \
        libtool \
        autoconf \
        curl procps bsdmainutils build-essential iproute2 tcptraceroute libffi-dev libc6 libgmp-dev libgmp10 libncurses-dev libncurses5 libtinfo5 \
    && apt-get clean

# checkout branch
ARG BRANCH
ARG VERSION
RUN echo "Building tags/$BRANCH..." \
    && echo tags/$BRANCH > /CARDANO_BRANCH \
    && git clone https://github.com/input-output-hk/cardano-node.git \
    && cd cardano-node \
    && git fetch --all --recurse-submodules --tags \
    && git tag \
    && git checkout tags/$BRANCH \
    && cd ../

# Install GHC
RUN wget https://downloads.haskell.org/~ghc/8.10.7/ghc-8.10.7-x86_64-deb10-linux.tar.xz   \
    && tar -xf ghc-8.10.7-x86_64-deb10-linux.tar.xz \
    && rm ghc-8.10.7-x86_64-deb10-linux.tar.xz \
    && cd ghc-8.10.7 \
    && ./configure \
    && make install \
    && cd / \
    && rm -rf /ghc-8.10.7

# Install cabal
ENV PATH="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/root/.cabal/bin:/root/.ghcup/bin:/root/.local/bin:/scripts:/scripts/functions"
RUN wget https://downloads.haskell.org/cabal/cabal-install-3.6.2.0/cabal-install-3.6.2.0-x86_64-linux-deb10.tar.xz \
    && tar -xf cabal-install-3.6.2.0-x86_64-linux-deb10.tar.xz \
    && rm cabal-install-3.6.2.0-x86_64-linux-deb10.tar.xz \
    && mkdir -p ~/.local/bin \
    && mv cabal ~/.local/bin/ \
    && chmod +x /root/.local/bin/cabal \
    && cabal clean \
    && cabal update

# Install libsodium
RUN git clone https://github.com/input-output-hk/libsodium \
    && cd libsodium \
    && git checkout 66f017f1 \
    && ./autogen.sh \
    && ./configure \
    && make \
    && make install \
    && cd .. && rm -rf libsodium

ENV LD_LIBRARY_PATH="/usr/local/lib" \
    PKG_CONFIG_PATH="/usr/local/lib/pkgconfig"

# Install secp256k1-node
RUN git clone https://github.com/bitcoin-core/secp256k1 \
    && cd secp256k1 \
    && git checkout ac83be33 \
    && ./autogen.sh \
    && ./configure --enable-module-schnorrsig --enable-experimental \
    && make \
    && make install

# Install llvm
RUN apt install llvm-9 -y \
    && apt install clang-9 libnuma-dev -y \
    && ln -s /usr/bin/llvm-config-9 /usr/bin/llvm-config \
    && ln -s /usr/bin/opt-9 /usr/bin/opt \
    && ln -s /usr/bin/llc-9 /usr/bin/llc \
    && ln -s /usr/bin/clang-9 /usr/bin/clang

# Install cardano-node
RUN echo "Compiling tags/$BRANCH..." \
    && cd cardano-node \
    && cabal update && cabal configure -O0 --with-compiler=ghc-8.10.7 \
    && echo "package cardano-crypto-praos" >>  cabal.project.local \
    && echo "  flags: -external-libsodium-vrf" >>  cabal.project.local \
    && cabal build cardano-node cardano-cli cardano-submit-api \
    && mkdir -p /root/.cabal/bin/ \
    && ls $(./scripts/bin-path.sh) \
    && cp -p "$(./scripts/bin-path.sh cardano-node)" /root/.cabal/bin/ \
    && cp -p "$(./scripts/bin-path.sh cardano-cli)" /root/.cabal/bin/ \
    && cp -p "$(./scripts/bin-path.sh cardano-submit-api)" /root/.cabal/bin/ \
    && rm -rf /root/.cabal/packages \
    && rm -rf /usr/local/lib/ghc-8.10.7/ \
    && rm -rf /cardano-node/dist-newstyle/ \
    && rm -rf /root/.cabal/store/ghc-8.10.7 \
    && ls -a /root/.cabal/bin/
