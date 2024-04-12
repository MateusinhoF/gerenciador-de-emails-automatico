create table users
(
    id                bigint unsigned auto_increment
        primary key,
    login             varchar(255) not null,
    email             varchar(255) not null,
    password          varchar(255) not null,
    senha_email       varchar(255) not null,
    assinatura        varchar(255) null,
    imagem_assinatura varchar(255) null,
    remember_token    varchar(100) null,
    created_at        timestamp    null,
    updated_at        timestamp    null,
    constraint users_email_unique
        unique (email)
)
    collate = utf8mb4_unicode_ci;

