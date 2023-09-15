FROM bitnami/git:latest as fortuna
RUN git clone --depth 1 https://github.com/aiken-lang/fortuna.git /fortuna

FROM denoland/deno:alpine-1.36.3 as base

WORKDIR /app

COPY --from=build /fortuna /app

CMD ["task", "cli", "mine"]+