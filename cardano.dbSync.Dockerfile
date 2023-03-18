FROM inputoutput/cardano-db-sync:13.1.0.2
ARG CARDANO_NETWORK
ARG NETWORK_CONFIG
RUN mkdir -p /config
COPY ${NETWORK_CONFIG} /config/
COPY src/pool/config/${CARDANO_NETWORK}/ /config/
COPY src/pool/config/build/ /config/