FROM inputoutput/cardano-db-sync:13.1.0.2
ARG NETWORK_CONFIG
RUN mkdir -p /config
COPY ${NETWORK_CONFIG} /tmp/config/
COPY src/pool/config/build/ /config/