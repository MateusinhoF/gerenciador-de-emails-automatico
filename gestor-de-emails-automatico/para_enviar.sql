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

