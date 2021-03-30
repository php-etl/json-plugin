<?php declare(strict_types=1);

namespace Kiboko\Plugin\JSON\Builder;

use PhpParser\Builder;
use PhpParser\Node;

final class Extractor implements Builder
{
    private ?Node\Expr $logger = null;

    public function __construct(private string $filePath)
    {
    }

    public function withLogger(Node\Expr $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    public function getNode(): Node
    {
        $arguments = [
            new Node\Arg(
                new Node\Expr\New_(
                    class: new Node\Name\FullyQualified('SplFileObject'),
                    args: [
                        new Node\Arg(
                            new Node\Scalar\String_($this->filePath)
                        ),
                        new Node\Arg(
                            new Node\Scalar\String_("r")
                        )
                    ]
                ),
                name: new Node\Identifier('file')
            )
        ];

        if ($this->logger !== null) {
            array_push(
                $arguments,
                new Node\Arg(
                    value: $this->logger,
                    name: new Node\Identifier('logger'),
                ),
            );
        }

        return new Node\Expr\New_(
            class: new Node\Name\FullyQualified('Kiboko\\Component\\Flow\\JSON\\Extractor'),
            args: $arguments
        );
    }
}
