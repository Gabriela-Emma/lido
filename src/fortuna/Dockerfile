FROM bitnami/git:latest as fortuna
RUN git clone --depth 1 https://github.com/aiken-lang/fortuna.git /fortuna

FROM denoland/deno:alpine-1.36.3

WORKDIR /app

COPY --from=fortuna /fortuna /app

RUN deno cache miner/main.ts

ENTRYPOINT ["deno"]

CMD ["run", "--allow-all", "miner/main.ts", "mine"]