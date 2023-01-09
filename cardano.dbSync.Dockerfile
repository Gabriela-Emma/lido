FROM inputoutput/cardano-db-sync:13.0.5
ARG NETWORK_CONFIG
RUN mkdir -p /config
COPY ${NETWORK_CONFIG} /config/
COPY src/pool/config/build/ /config/