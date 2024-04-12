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

