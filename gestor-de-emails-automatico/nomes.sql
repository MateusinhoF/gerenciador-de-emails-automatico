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

