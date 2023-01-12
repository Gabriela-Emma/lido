FROM inputoutput/cardano-db-sync:13.1.0.0
ARG NETWORK_CONFIG
RUN mkdir -p /config
COPY ${NETWORK_CONFIG} /config/
COPY src/pool/config/build/ /config/