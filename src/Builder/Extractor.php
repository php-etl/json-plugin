<?php declare(strict_types=1);

namespace Kiboko\Plugin\JSON\Builder;

use PhpParser\Builder;
use PhpParser\Node;

final class Extractor implements Builder
{
    public function __construct(private string $filePath)
    {
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

        return new Node\Expr\New_(
            class: new Node\Name\FullyQualified('Kiboko\\Component\\Flow\\JSON\\Extractor'),
            args: $arguments
        );
    }
}
