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

