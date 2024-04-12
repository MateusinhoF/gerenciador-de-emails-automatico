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

