create table failed_jobs
(
    id         bigint unsigned auto_increment
        primary key,
    uuid       varchar(255)                        not null,
    connection text                                not null,
    queue      text                                not null,
    payload    longtext                            not null,
    exception  longtext                            not null,
    failed_at  timestamp default CURRENT_TIMESTAMP not null,
    constraint failed_jobs_uuid_unique
        unique (uuid)
)
    collate = utf8mb4_unicode_ci;

create table migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    collate = utf8mb4_unicode_ci;

create table password_reset_tokens
(
    email      varchar(255) not null
        primary key,
    token      varchar(255) not null,
    created_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table personal_access_tokens
(
    id             bigint unsigned auto_increment
        primary key,
    tokenable_type varchar(255)    not null,
    tokenable_id   bigint unsigned not null,
    name           varchar(255)    not null,
    token          varchar(64)     not null,
    abilities      text            null,
    last_used_at   timestamp       null,
    expires_at     timestamp       null,
    created_at     timestamp       null,
    updated_at     timestamp       null,
    constraint personal_access_tokens_token_unique
        unique (token)
)
    collate = utf8mb4_unicode_ci;

create index personal_access_tokens_tokenable_type_tokenable_id_index
    on personal_access_tokens (tokenable_type, tokenable_id);

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

create table anexos
(
    id         bigint unsigned auto_increment
        primary key,
    user_id    bigint unsigned not null,
    nome       varchar(255)    not null,
    hashname   varchar(255)    not null,
    created_at timestamp       null,
    updated_at timestamp       null,
    constraint anexos_user_id_foreign
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

create table emails
(
    id         bigint unsigned auto_increment
        primary key,
    user_id    bigint unsigned not null,
    email      varchar(255)    not null,
    descricao  varchar(255)    null,
    created_at timestamp       null,
    updated_at timestamp       null,
    constraint emails_user_id_foreign
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

create table nomes
(
    id         bigint unsigned auto_increment
        primary key,
    user_id    bigint unsigned not null,
    nome1      varchar(255)    not null,
    nome2      varchar(255)    null,
    nome3      varchar(255)    null,
    nome4      varchar(255)    null,
    nome5      varchar(255)    null,
    created_at timestamp       null,
    updated_at timestamp       null,
    constraint nomes_user_id_foreign
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

create table titulo_lista_de_emails
(
    id         bigint unsigned auto_increment
        primary key,
    user_id    bigint unsigned not null,
    titulo     varchar(255)    not null,
    created_at timestamp       null,
    updated_at timestamp       null,
    constraint titulo_lista_de_emails_user_id_foreign
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

create table lista_de_emails
(
    id                        bigint unsigned auto_increment
        primary key,
    user_id                   bigint unsigned not null,
    titulo_lista_de_emails_id bigint unsigned not null,
    emails_id                 bigint unsigned not null,
    created_at                timestamp       null,
    updated_at                timestamp       null,
    constraint lista_de_emails_emails_id_foreign
        foreign key (emails_id) references emails (id),
    constraint lista_de_emails_titulo_lista_de_emails_id_foreign
        foreign key (titulo_lista_de_emails_id) references titulo_lista_de_emails (id),
    constraint lista_de_emails_user_id_foreign
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

create table vinculador_anexos
(
    id         bigint unsigned auto_increment
        primary key,
    user_id    bigint unsigned not null,
    created_at timestamp       null,
    updated_at timestamp       null,
    constraint vinculador_anexos_user_id_foreign
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

create table corpo_email
(
    id                   bigint unsigned auto_increment
        primary key,
    user_id              bigint unsigned not null,
    titulo               varchar(255)    not null,
    assunto              varchar(255)    not null,
    texto                varchar(255)    not null,
    vinculador_anexos_id bigint unsigned null,
    created_at           timestamp       null,
    updated_at           timestamp       null,
    constraint corpo_email_user_id_foreign
        foreign key (user_id) references users (id),
    constraint corpo_email_vinculador_anexos_id_foreign
        foreign key (vinculador_anexos_id) references vinculador_anexos (id)
)
    collate = utf8mb4_unicode_ci;

create table lista_anexos
(
    id                   bigint unsigned auto_increment
        primary key,
    user_id              bigint unsigned not null,
    vinculador_anexos_id bigint unsigned not null,
    anexos_id            bigint unsigned not null,
    created_at           timestamp       null,
    updated_at           timestamp       null,
    constraint lista_anexos_anexos_id_foreign
        foreign key (anexos_id) references anexos (id),
    constraint lista_anexos_user_id_foreign
        foreign key (user_id) references users (id),
    constraint lista_anexos_vinculador_anexos_id_foreign
        foreign key (vinculador_anexos_id) references vinculador_anexos (id)
)
    collate = utf8mb4_unicode_ci;

create table para_enviar
(
    id                            bigint unsigned auto_increment
        primary key,
    user_id                       bigint unsigned      not null,
    titulo                        varchar(255)         not null,
    nomes_id                      bigint unsigned      null,
    corpo_email_id                bigint unsigned      not null,
    titulo_lista_de_emails_id     bigint unsigned      not null,
    titulo_lista_de_emails_cc_id  bigint unsigned      null,
    titulo_lista_de_emails_cco_id bigint unsigned      null,
    continuar_envio               tinyint(1) default 1 not null,
    data_inicio                   date                 null,
    data_fim                      date                 null,
    created_at                    timestamp            null,
    updated_at                    timestamp            null,
    constraint para_enviar_corpo_email_id_foreign
        foreign key (corpo_email_id) references corpo_email (id),
    constraint para_enviar_nomes_id_foreign
        foreign key (nomes_id) references nomes (id),
    constraint para_enviar_titulo_lista_de_emails_cc_id_foreign
        foreign key (titulo_lista_de_emails_cc_id) references titulo_lista_de_emails (id),
    constraint para_enviar_titulo_lista_de_emails_cco_id_foreign
        foreign key (titulo_lista_de_emails_cco_id) references titulo_lista_de_emails (id),
    constraint para_enviar_titulo_lista_de_emails_id_foreign
        foreign key (titulo_lista_de_emails_id) references titulo_lista_de_emails (id),
    constraint para_enviar_user_id_foreign
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

